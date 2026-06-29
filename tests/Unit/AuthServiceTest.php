<?php

namespace Tests\Unit;

use App\Models\Pet;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Unit tests untuk AuthService.
 *
 * Menggunakan database SQLite in-memory (via RefreshDatabase) karena
 * AuthService berinteraksi langsung dengan Eloquent models dan Auth facade.
 */
class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    // ──────────────────────────────────────────────────────────────
    //  REGISTER
    // ──────────────────────────────────────────────────────────────

    /** Memastikan register() membuat user baru di database. */
    public function test_register_creates_user_in_database(): void
    {
        $data = [
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => 'password123',
            'phone'    => '08123456789',
        ];

        $result = $this->authService->register($data);

        $this->assertDatabaseHas('users', [
            'name'  => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'role'  => 'customer',
        ]);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals('Budi Santoso', $result['name']);
    }

    /** Password harus di-hash, bukan disimpan plaintext. */
    public function test_register_hashes_password(): void
    {
        $this->authService->register([
            'name'     => 'Ani',
            'email'    => 'ani@example.com',
            'password' => 'secret123',
        ]);

        $user = User::where('email', 'ani@example.com')->first();

        $this->assertNotEquals('secret123', $user->password);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    /** Role default harus selalu 'customer'. */
    public function test_register_sets_default_role_to_customer(): void
    {
        $this->authService->register([
            'name'     => 'Cici',
            'email'    => 'cici@example.com',
            'password' => 'pass',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'cici@example.com',
            'role'  => 'customer',
        ]);
    }

    /** Field phone bersifat opsional. */
    public function test_register_without_phone_works(): void
    {
        $result = $this->authService->register([
            'name'     => 'Doni',
            'email'    => 'doni@example.com',
            'password' => 'pass',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'doni@example.com']);
        $this->assertNull($result['phone'] ?? null);
    }

    /** register() mengembalikan array yang berisi data user. */
    public function test_register_returns_array_with_user_data(): void
    {
        $result = $this->authService->register([
            'name'     => 'Eko',
            'email'    => 'eko@example.com',
            'password' => 'pass',
        ]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
    }

    // ──────────────────────────────────────────────────────────────
    //  LOGIN
    // ──────────────────────────────────────────────────────────────

    /** login() mengembalikan nama user jika credentials valid. */
    public function test_login_returns_user_name_on_valid_credentials(): void
    {
        User::factory()->create([
            'email'    => 'valid@example.com',
            'password' => Hash::make('correctpassword'),
            'name'     => 'Fani Wijaya',
        ]);

        $result = $this->authService->login('valid@example.com', 'correctpassword');

        $this->assertEquals('Fani Wijaya', $result);
    }

    /** login() mengembalikan null jika password salah. */
    public function test_login_returns_null_on_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => Hash::make('correctpassword'),
        ]);

        $result = $this->authService->login('user@example.com', 'wrongpassword');

        $this->assertNull($result);
    }

    /** login() mengembalikan null jika email tidak ditemukan. */
    public function test_login_returns_null_for_nonexistent_email(): void
    {
        $result = $this->authService->login('ghost@example.com', 'any');

        $this->assertNull($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  LOGOUT
    // ──────────────────────────────────────────────────────────────

    /** logout() selalu mengembalikan true. */
    public function test_logout_returns_true(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $result = $this->authService->logout($user->id);

        $this->assertTrue($result);
    }

    /** Setelah logout, user tidak lagi terautentikasi. */
    public function test_logout_deauthenticates_user(): void
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->authService->logout($user->id);

        $this->assertNull(Auth::user());
    }

    // ──────────────────────────────────────────────────────────────
    //  GET USER PROFILE
    // ──────────────────────────────────────────────────────────────

    /** getUserProfile() mengembalikan array data user. */
    public function test_get_user_profile_returns_user_data(): void
    {
        $user = User::factory()->create(['name' => 'Gita Pratama']);

        $result = $this->authService->getUserProfile($user->id);

        $this->assertIsArray($result);
        $this->assertEquals($user->id, $result['id']);
        $this->assertEquals('Gita Pratama', $result['name']);
    }

    /** getUserProfile() melempar exception jika user tidak ditemukan. */
    public function test_get_user_profile_throws_exception_for_nonexistent_user(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->authService->getUserProfile(99999);
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE USER PROFILE
    // ──────────────────────────────────────────────────────────────

    /** updateUserProfile() berhasil memperbarui data user. */
    public function test_update_user_profile_updates_data(): void
    {
        $user = User::factory()->create(['name' => 'Hendra Lama']);

        $result = $this->authService->updateUserProfile($user->id, [
            'name'  => 'Hendra Baru',
            'phone' => '08999999999',
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('users', [
            'id'    => $user->id,
            'name'  => 'Hendra Baru',
            'phone' => '08999999999',
        ]);
    }

    /** updateUserProfile() mengembalikan false jika user tidak ditemukan. */
    public function test_update_user_profile_returns_false_for_nonexistent_user(): void
    {
        $result = $this->authService->updateUserProfile(99999, ['name' => 'Nobody']);

        $this->assertFalse($result);
    }

    /** updateUserProfile() harus meng-hash password baru jika diberikan. */
    public function test_update_user_profile_hashes_new_password(): void
    {
        $user = User::factory()->create();

        $this->authService->updateUserProfile($user->id, ['password' => 'newpassword']);

        $fresh = $user->fresh();
        $this->assertTrue(Hash::check('newpassword', $fresh->password));
    }

    /** Jika tidak ada password baru, password lama tidak berubah. */
    public function test_update_user_profile_keeps_password_if_not_provided(): void
    {
        $user = User::factory()->create(['password' => Hash::make('original')]);

        $this->authService->updateUserProfile($user->id, ['name' => 'Changed Name']);

        $fresh = $user->fresh();
        $this->assertTrue(Hash::check('original', $fresh->password));
    }

    // ──────────────────────────────────────────────────────────────
    //  GET USER PETS
    // ──────────────────────────────────────────────────────────────

    /** getUserPets() mengembalikan array pets milik user. */
    public function test_get_user_pets_returns_pets_belonging_to_user(): void
    {
        $user = User::factory()->create();

        Pet::create(['user_id' => $user->id, 'name' => 'Mochi', 'species' => 'Kucing']);
        Pet::create(['user_id' => $user->id, 'name' => 'Rex',   'species' => 'Anjing']);

        $result = $this->authService->getUserPets($user->id);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    /** getUserPets() tidak mengembalikan pet milik user lain. */
    public function test_get_user_pets_does_not_return_other_users_pets(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Pet::create(['user_id' => $userA->id, 'name' => 'Luna',  'species' => 'Kucing']);
        Pet::create(['user_id' => $userB->id, 'name' => 'Buddy', 'species' => 'Anjing']);

        $result = $this->authService->getUserPets($userA->id);

        $this->assertCount(1, $result);
        $this->assertEquals('Luna', $result[0]['name']);
    }

    /** getUserPets() mengembalikan array kosong jika tidak ada pet. */
    public function test_get_user_pets_returns_empty_array_when_no_pets(): void
    {
        $user = User::factory()->create();

        $result = $this->authService->getUserPets($user->id);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    // ──────────────────────────────────────────────────────────────
    //  SAVE USER PET – CREATE
    // ──────────────────────────────────────────────────────────────

    /** saveUserPet() membuat pet baru jika tidak ada id. */
    public function test_save_user_pet_creates_new_pet(): void
    {
        $user = User::factory()->create();

        $result = $this->authService->saveUserPet($user->id, [
            'name'    => 'Kitty',
            'species' => 'Kucing',
            'gender'  => 'female',
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('pets', [
            'user_id' => $user->id,
            'name'    => 'Kitty',
            'species' => 'Kucing',
        ]);
    }

    /** saveUserPet() secara otomatis mengisi user_id dari parameter. */
    public function test_save_user_pet_assigns_correct_user_id(): void
    {
        $user = User::factory()->create();

        $this->authService->saveUserPet($user->id, [
            'name'    => 'Fluffy',
            'species' => 'Kucing',
        ]);

        $this->assertDatabaseHas('pets', ['user_id' => $user->id, 'name' => 'Fluffy']);
    }

    // ──────────────────────────────────────────────────────────────
    //  SAVE USER PET – UPDATE
    // ──────────────────────────────────────────────────────────────

    /** saveUserPet() memperbarui pet yang sudah ada jika id diberikan. */
    public function test_save_user_pet_updates_existing_pet(): void
    {
        $user = User::factory()->create();
        $pet  = Pet::create(['user_id' => $user->id, 'name' => 'Tua', 'species' => 'Anjing']);

        $result = $this->authService->saveUserPet($user->id, [
            'id'      => $pet->id,
            'name'    => 'Baru',
            'species' => 'Anjing',
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('pets', ['id' => $pet->id, 'name' => 'Baru']);
    }

    /** saveUserPet() mengembalikan false jika pet bukan milik user tersebut. */
    public function test_save_user_pet_returns_false_if_pet_belongs_to_other_user(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $pet   = Pet::create(['user_id' => $userB->id, 'name' => 'Asing', 'species' => 'Kucing']);

        $result = $this->authService->saveUserPet($userA->id, [
            'id'      => $pet->id,
            'name'    => 'Hijacked',
            'species' => 'Kucing',
        ]);

        $this->assertFalse($result);
        $this->assertDatabaseHas('pets', ['id' => $pet->id, 'name' => 'Asing']);
    }
}
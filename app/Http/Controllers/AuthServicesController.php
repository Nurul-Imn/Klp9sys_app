<?php

namespace App\Http\Controllers;

use App\Contract\AuthServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceContract $authService
    ) {}

    // =========================================================================
    // REGISTER
    // =========================================================================

    /** Show registration form. */
    public function showRegister()
    {
        return view('auth.register');
    }

    /** Handle registration form submission. */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'phone'                 => 'nullable|string|max:20',
        ]);

        $this->authService->register($validated);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // =========================================================================
    // LOGIN
    // =========================================================================

    /** Show login form. */
    public function showLogin()
    {
        return view('auth.login');
    }

    /** Handle login form submission. */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($validated['email'], $validated['password']);

        if ($result === null) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        return redirect()->intended(route('dashboard'))->with('success', 'Login berhasil!');
    }

    // =========================================================================
    // LOGOUT
    // =========================================================================

    /** Handle logout. */
    public function logout(Request $request)
    {
        $userId = Auth::id();

        $this->authService->logout((int) $userId);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // =========================================================================
    // PROFILE
    // =========================================================================

    /** Show authenticated user's profile. */
    public function showProfile()
    {
        $profile = $this->authService->getUserProfile((int) Auth::id());
        $pets    = $this->authService->getUserPets((int) Auth::id());

        return view('auth.profile', compact('profile', 'pets'));
    }

    /** Handle profile update. */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email,' . Auth::id(),
            'phone'                 => 'nullable|string|max:20',
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        // Remove password keys if not provided so service doesn't hash empty string
        if (empty($validated['password'])) {
            unset($validated['password'], $validated['password_confirmation']);
        }

        $updated = $this->authService->updateUserProfile((int) Auth::id(), $validated);

        if (!$updated) {
            return back()->withErrors(['general' => 'Gagal memperbarui profil.']);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // =========================================================================
    // PETS
    // =========================================================================

    /** Show pet management page for the authenticated user. */
    public function showPets()
    {
        $pets = $this->authService->getUserPets((int) Auth::id());

        return view('auth.pets', compact('pets'));
    }

    /** Handle save (create or update) a pet. */
    public function savePet(Request $request)
    {
        $validated = $request->validate([
            'id'      => 'nullable|integer|exists:pets,id',
            'name'    => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed'   => 'nullable|string|max:100',
            'age'     => 'nullable|integer|min:0',
            'weight'  => 'nullable|numeric|min:0',
            'notes'   => 'nullable|string',
        ]);

        $saved = $this->authService->saveUserPet((int) Auth::id(), $validated);

        if (!$saved) {
            return back()->withErrors(['general' => 'Gagal menyimpan data hewan peliharaan.']);
        }

        $message = !empty($validated['id']) ? 'Data hewan berhasil diperbarui!' : 'Hewan peliharaan berhasil ditambahkan!';

        return back()->with('success', $message);
    }
}
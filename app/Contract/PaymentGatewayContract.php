<?php

namespace App\Contract;

interface PaymentGatewayContract
{
    public function createPayment(array $checkoutData): array;

    public function generatePaymentLink(array $checkoutData): string;

    public function verifyPayment(string $transactionId): bool;

    public function handleWebhook(array $payload): bool;

    public function getPaymentStatus(string $transactionId): string;
}

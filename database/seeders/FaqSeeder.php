<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // Account & Registration
            ['question' => 'How do I create an account?', 'answer' => 'Click on the "Register" button and fill in your details. You\'ll receive a verification email to activate your account.', 'category' => 'account'],
            ['question' => 'I forgot my password, what should I do?', 'answer' => 'Use the "Forgot Password" link on the login page. Enter your email and follow the instructions sent to your inbox.', 'category' => 'account'],
            ['question' => 'How do I verify my email address?', 'answer' => 'Check your email for a verification code and enter it when prompted, or click the verification link in the email.', 'category' => 'account'],
            
            // Coins & Payments
            ['question' => 'What are coins and how do I get them?', 'answer' => 'Coins are our platform currency. You can purchase coin packages through various payment methods in the Wallet section.', 'category' => 'coins'],
            ['question' => 'What payment methods do you accept?', 'answer' => 'We accept major credit cards, PayPal, bank transfers, and various digital payment methods.', 'category' => 'coins'],
            ['question' => 'How long does it take for coin purchases to be processed?', 'answer' => 'Most payments are processed instantly. Bank transfers may take 1-3 business days.', 'category' => 'coins'],
            
            // Marketplace & Orders
            ['question' => 'How do I place an order?', 'answer' => 'Browse the marketplace, add items to your cart, and proceed to checkout. You\'ll need sufficient coins in your wallet.', 'category' => 'orders'],
            ['question' => 'Can I cancel my order?', 'answer' => 'Orders can be cancelled within 1 hour of placement if they haven\'t been processed by the seller.', 'category' => 'orders'],
            ['question' => 'How do I track my order?', 'answer' => 'Go to your Orders section in your dashboard to view order status and tracking information.', 'category' => 'orders'],
            
            // General
            ['question' => 'Is my personal information secure?', 'answer' => 'Yes, we use industry-standard encryption and security measures to protect your data.', 'category' => 'general'],
            ['question' => 'How do I contact customer support?', 'answer' => 'You can reach us via live chat, WhatsApp, email, or request a callback through our Support Center.', 'category' => 'general'],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::create(array_merge($faq, ['order' => $index + 1]));
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\HelpArticle;
use Illuminate\Database\Seeder;

class HelpArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Getting Started with Your Account',
                'content' => "Welcome to our platform! Here's how to get started:\n\n1. Complete your profile information\n2. Verify your email address\n3. Add a profile picture\n4. Explore the marketplace\n5. Purchase your first coin package\n\nOnce you've completed these steps, you'll be ready to start buying and selling on our platform.",
                'category' => 'getting-started',
                'type' => 'guide',
                'is_featured' => true,
                'order' => 1
            ],
            [
                'title' => 'How to Purchase Coins',
                'content' => "Coins are the currency of our platform. Here's how to buy them:\n\n1. Go to your Wallet section\n2. Click 'Buy Coins'\n3. Choose a coin package\n4. Select your payment method\n5. Complete the payment\n6. Coins will be added to your wallet instantly\n\nSupported payment methods include credit cards, PayPal, and bank transfers.",
                'category' => 'wallet-coins',
                'type' => 'tutorial',
                'is_featured' => true,
                'order' => 2
            ],
            [
                'title' => 'Creating Your First Store',
                'content' => "Ready to start selling? Here's how to create your store:\n\n1. Go to Stores section\n2. Click 'Create Store'\n3. Choose a unique store handle (e.g., @yourstore)\n4. Add store description and logo\n5. Set up your first products\n6. Publish your store\n\nYour store will be live immediately and accessible to all users.",
                'category' => 'selling',
                'type' => 'guide',
                'is_featured' => true,
                'order' => 3
            ],
            [
                'title' => 'Understanding Order Status',
                'content' => "Track your orders with these status meanings:\n\n• Pending: Order placed, waiting for seller confirmation\n• Confirmed: Seller accepted, preparing item\n• Shipped: Item sent, tracking available\n• Delivered: Item received by buyer\n• Completed: Transaction finished\n• Cancelled: Order cancelled by buyer or seller\n\nYou'll receive notifications for each status change.",
                'category' => 'orders',
                'type' => 'guide',
                'order' => 4
            ],
            [
                'title' => 'Troubleshooting Payment Issues',
                'content' => "Having payment problems? Try these solutions:\n\n1. Check your card details are correct\n2. Ensure sufficient funds in your account\n3. Try a different payment method\n4. Clear your browser cache\n5. Disable ad blockers\n6. Contact your bank if card is declined\n\nIf issues persist, contact our support team with your transaction details.",
                'category' => 'troubleshooting',
                'type' => 'troubleshooting',
                'is_featured' => false,
                'order' => 5
            ]
        ];

        foreach ($articles as $article) {
            HelpArticle::create($article);
        }
    }
}
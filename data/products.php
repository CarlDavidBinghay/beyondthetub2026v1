<?php
/**
 * The menu. Two flavours for launch, two sizes each.
 * PRICES ARE PLACEHOLDERS — set your real ones here.
 * The order of sizes matters: index 0 = 8oz, index 1 = 12oz. Stock in config.php uses those indexes.
 */

const PRODUCTS = [
    [
        'id'        => 'biscoff',
        'name'      => 'Biscoff',
        'photo'     => 'assets/brand/biscoff.jpg',
        'badge'     => 'Launch flavour',
        'allergens' => 'Homemade Pudding, Banana, Biscoff Spread, Biscoff Cookie',
        'keeps'     => 'Keep refrigerated (do not freeze) and enjoy within 2–3 days for the best freshness, taste, and texture.',
        'sizes'     => [
            ['label' => '8oz tub',  'serves' => 'One person, one sitting', 'price' => 159],
            ['label' => '12oz tub', 'serves' => 'Share between two',       'price' => 219],
        ],
    ],
    [
        'id'        => 'classic',
        'name'      => 'Classic',
        'photo'     => 'assets/brand/classic.jpg',
        'badge'     => 'The original',
        'allergens' => 'Homemade Pudding, Banana, Eggnog',
        'keeps'     => 'Keep refrigerated (do not freeze) and enjoy within 2–3 days for the best freshness, taste, and texture.',
        'sizes'     => [
            ['label' => '8oz tub',  'serves' => 'One person, one sitting', 'price' => 129],
            ['label' => '12oz tub', 'serves' => 'Share between two',       'price' => 179],
        ],
    ],
];

const FAQS = [
    [
        'q' => 'Where do you deliver?',
        'a' => 'Cebu only for now. We deliver within Cebu City, Mandaue, Lapu-Lapu, and Talisay. Delivery fees vary depending on your location.,
    ],
    [
        'q' => 'Can I pick it up instead?',
        'a' => 'Yes, and it is free. Choose pickup at checkout, pick a window, and we send the exact pin once your order is confirmed.',
    ],
    [
        'q' => 'How do I pay?',
        'a' => 'Scan our QR to pay online — then send the reference number and a screenshot so we can match it to your order. If you would rather not pay upfront, choose cash on delivery or on pickup and hand it over on the day.',
    ],
    [
        'q' => 'How long does a tub keep?',
        'a' => 'Keep refrigerated (do not freeze) and enjoy within 2–3 days for the best freshness, taste, and texture.',
    ],
    [
        'q' => 'Any allergies?',
        'a' => 'please review the ingredient list provided for each pudding before consuming.',
    ],
];
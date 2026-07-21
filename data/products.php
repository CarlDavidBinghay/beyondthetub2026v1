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
        'blurb'     => 'Layers of Biscoff spread and crushed cookie through cold, slow-cooked cream.',
        'details'   => 'The biscuit goes in three times — crushed at the base, spread through the middle, and a hard layer of rubble on top that stays crunchy until you open the lid. Sweet, but it knows when to stop.',
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
        'blurb'     => 'The one we started with. Vanilla cream, ripe banana, soft biscuit layers.',
        'details'   => 'Made the same way it was made for friends before anyone was paying: cream cooked low, bananas sliced in that morning, biscuit left to soften overnight so the whole tub eats like one thing instead of layers.',
        'allergens' => 'Wheat, dairy, egg, soy',
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
        'a' => 'Cebu only for now. Our rider covers Cebu City, Mandaue, Lapu-Lapu and Talisay for a flat fee. Anywhere else in Cebu, book a Lalamove or Grab and we will hand your order to the rider.',
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
        'q' => 'When will my order be made?',
        'a' => 'You pick a production date at checkout — those are the days we actually cook. Everything is made fresh for that date, so we need at least a day’s notice.',
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
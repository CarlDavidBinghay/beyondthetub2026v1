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
        'allergens' => 'Wheat, dairy, egg, soy',
        'keeps'     => '4 days chilled. Do not freeze.',
        'sizes'     => [
            ['label' => '8oz tub',  'serves' => 'One person, one sitting', 'price' => 180],
            ['label' => '12oz tub', 'serves' => 'Share between two',       'price' => 250],
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
        'keeps'     => '4 days chilled. Do not freeze.',
        'sizes'     => [
            ['label' => '8oz tub',  'serves' => 'One person, one sitting', 'price' => 170],
            ['label' => '12oz tub', 'serves' => 'Share between two',       'price' => 240],
        ],
    ],
];

const FAQS = [
    [
        'q' => 'How many tubs are there?',
        'a' => 'Twenty of each size, per flavour, for this launch — eighty tubs in total. When the counter on a size hits zero, that size is gone until the next batch. Nothing is held back.',
    ],
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
        'a' => 'Four days in the fridge with the lid on. Do not freeze it — the cream splits when it thaws and there is no saving it.',
    ],
    [
        'q' => 'Any allergens?',
        'a' => 'Both flavours contain wheat, dairy, egg and soy, and they are made in one small kitchen with shared equipment. If your allergy is serious, message us before ordering.',
    ],
];

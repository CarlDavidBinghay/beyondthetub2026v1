<?php
/**
 * Beyond The Tub — shop configuration
 * Change the shop here. Nothing else needs editing for day-to-day changes.
 */

date_default_timezone_set('Asia/Manila');

const SHOP = [
    'name'      => 'Beyond The Tub',
    'tagline'   => 'Small-batch tubs, made in Cebu.',
    'instagram' => 'beyondthetub',
    'ig_url'    => 'https://instagram.com/beyondthetub',
    'email'     => 'hello@beyondthetub.ph',
    'currency'  => '₱',
    'timezone'  => 'Asia/Manila',
    'city'      => 'Cebu',
];

/**
 * IMAGE SLOTS — every picture on the site comes from here.
 * These are the files you sent, mapped to a role. If one is in the wrong slot,
 * open assets.php in your browser to see them all side by side, then fix the
 * filename below. No other file needs touching.
 */
const ASSETS = [
    'logo'    => 'assets/brand/logo.png',
    'hero'    => 'assets/brand/hero.png',
    'poster_a'=> 'assets/brand/poster-a.png',
    'poster_b'=> 'assets/brand/poster-b.png',
    'menu'    => 'assets/brand/menu.jpg',
    'qr'      => 'assets/brand/qr.png',   // shown when someone pays online
];

/** We only serve Cebu for launch. */
const SERVICE_AREAS = [
    'Cebu City', 'Mandaue', 'Lapu-Lapu (Mactan)', 'Talisay', 'Consolacion', 'Minglanilla',
];

/** Pickup point — you message this to the customer yourself, from admin.php. */
const PICKUP = [
    'name'      => 'Beyond The Tub kitchen',
    'address'   => 'Please set your exact pickup address in config.php',
    'area'      => 'Cebu City',
    'maps_url'  => 'https://maps.google.com/?q=Cebu+City',
    'window'    => 'Come within the pickup window you picked at checkout.',
];

/** The message admin sends to anyone collecting, or booking their own rider. */
const PICKUP_MESSAGE = "Hi {name}! Your Beyond The Tub order {ref} is confirmed for {date}, {slot}.\n\nPickup here: " . PICKUP['name'] . "\n" . PICKUP['address'] . ", " . PICKUP['area'] . "\nMap: " . PICKUP['maps_url'] . "\n\nTotal: {total}. See you then!";

const DELIVERY_METHODS = [
    'pickup' => [
        'label' => 'Pick up',
        'area'  => 'Cebu City',
        'fee'   => 0,
        'needs_address'  => false,
        'send_location'  => true,   // admin messages them the pin
        'note'  => 'We message you the exact location once your order is confirmed.',
    ],
    'rider' => [
        'label' => 'Delivery — our rider',
        'area'  => '',
        'fee'   => 0,
        'needs_address'  => true,
        'quote_later'    => true,   // fee depends on the address, so we agree it after
        'note'  => '',
    ],
    'book' => [
        'label' => 'Delivery — you book the rider',
        'area'  => 'Anywhere in Cebu',
        'fee'   => 0,
        'needs_address'  => false,  // they send their own rider to us
        'send_location'  => true,   // so they need our location too
        'note'  => 'Book Maxim or Grab. We message you the pickup location for your rider, and you pay the rider directly.',
    ],
];

/**
 * PRODUCTION DATES — the days you actually cook.
 * These are the defaults. You can add or remove dates any time from admin.php
 * without editing this file (they are stored in storage/production-dates.json).
 */
const DEFAULT_PRODUCTION_DATES = [
    // 'YYYY-MM-DD' => 'label shown to the customer'
];

/** If no dates are set yet, offer the next N open days automatically. */
const AUTO_DATE_DAYS = 10;
const CLOSED_WEEKDAYS = [0];        // Sunday off
const LEAD_TIME_HOURS = 24;

const TIME_SLOTS = [
    '10:00 AM – 12:00 NN',
    '1:00 PM – 3:00 PM',
    '3:00 PM – 5:00 PM',
    '5:00 PM – 7:00 PM',
];

/** Launch stock. Enforced everywhere — the cart cannot go past these. */
const LAUNCH_STOCK = [
    'biscoff|0' => 20,   // Biscoff  8oz  → 20 tubs
    'biscoff|1' => 20,   // Biscoff 12oz  → 20 tubs
    'classic|0' => 20,   // Classic  8oz  → 20 tubs
    'classic|1' => 20,   // Classic 12oz  → 20 tubs
];


const PAYMENT_METHODS = [
    'online' => [
        'label'      => 'Pay online (GCash / QR)',
        'note'       => 'Scan the QR, then send us the reference number and a screenshot.',
        'needs_proof'=> true,
    ],
    'cod' => [
        'label'      => 'Cash on delivery / on pickup',
        'note'       => 'Pay the exact amount when you receive your tubs. Please prepare change.',
        'needs_proof'=> false,
    ],
];

/** "How did you hear about us?" — shown to everyone. */
const REFERRAL_SOURCES = [
    'Instagram', 'Facebook', 'TikTok', 'A friend told me', 'Saw it in person', 'Somewhere else',
];

/** Your existing Google Form — kept as a backup way to order. */
const GOOGLE_FORM_URL = 'https://docs.google.com/forms/d/1jwN2TvEjpt6XL2L0YUQe33WTlCNBIljH_wGqQD7RZ94/viewform';

/**
 * OPTIONAL — copy every order into that same Google Form automatically.
 * See README ("Sending orders into your Google Form") for how to get these IDs.
 * Leave 'enabled' false and the site simply links to the form instead.
 */
const GOOGLE_FORM_SYNC = [
    'enabled'  => false,
    'post_url' => '',  // https://docs.google.com/forms/d/e/XXXX/formResponse
    'fields'   => [
        'name'      => '',   // e.g. 'entry.123456789'
        'phone'     => '',
        'email'     => '',
        'order'     => '',
        'total'     => '',
        'schedule'  => '',
        'method'    => '',
        'address'   => '',
        'payment'   => '',
        'reference' => '',
    ],
];

/**
 * ORDER ALERTS — so you know an order came in without watching admin.php.
 * Everything is optional. Leave a value empty and that channel is simply skipped.
 * See README ("Getting told when someone orders") for how to fill these in.
 */
const NOTIFY = [
    'telegram_token'   => '',   // from @BotFather, looks like 123456:AAH...
    'telegram_chat_id' => '',   // from @userinfobot — your own numeric ID
    'discord_webhook'  => '',   // Server settings → Integrations → New webhook
    'email_to'         => '',   // only works if your host can send mail; XAMPP usually cannot
];

/** Passcode for admin.php — change this. */
const ADMIN_CODE = 'tub2026';

const STORAGE_DIR  = __DIR__ . '/storage/orders';
const PROOF_DIR    = __DIR__ . '/storage/proofs';
const STOCK_FILE   = __DIR__ . '/storage/stock.json';
const DATES_FILE   = __DIR__ . '/storage/production-dates.json';

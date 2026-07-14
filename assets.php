<?php
$pageTitle = 'Image slots';
require __DIR__ . '/includes/header.php';

$slots = [
    'logo'     => ['Logo', 'Header, footer, favicon, confirmation page.'],
    'hero'     => ['Hero image', 'The big picture on the homepage.'],
    'menu'     => ['Menu image', 'The panel above the FAQ.'],
    'qr'       => ['Payment QR', 'Shown at checkout when someone pays online.'],
    'poster_a' => ['Spare A', 'Not used yet — swap it into any slot above.'],
    'poster_b' => ['Spare B', 'Not used yet.'],
];
?>
<main class="mx-auto max-w-4xl px-5 py-14">
  <h1 class="font-display text-4xl font-bold">Image slots</h1>
  <p class="mt-2 max-w-xl text-cocoa">
    Every picture on the site comes from one of these slots. If a picture is in the wrong place, open
    <span class="font-mono text-sm">config.php</span> and change the filename next to the slot name in <span class="font-mono text-sm">ASSETS</span>.
    Product photos live in <span class="font-mono text-sm">data/products.php</span> under <span class="font-mono text-sm">photo</span>.
  </p>

  <div class="mt-10 grid gap-6 sm:grid-cols-2 md:grid-cols-3">
    <?php foreach ($slots as $key => [$title, $where]):
      $path = ASSETS[$key] ?? ''; ?>
      <figure class="rounded-3xl border-2 border-ink bg-white p-4">
        <img src="<?= e($path) ?>" alt="<?= e($title) ?>" class="h-48 w-full rounded-2xl border-2 border-ink object-cover">
        <figcaption class="mt-3">
          <p class="font-display text-lg font-bold"><?= e($title) ?></p>
          <p class="text-sm text-cocoa"><?= e($where) ?></p>
          <p class="mt-2 font-mono text-xs text-cocoa">ASSETS['<?= e($key) ?>']</p>
          <p class="font-mono text-xs"><?= e($path) ?></p>
        </figcaption>
      </figure>
    <?php endforeach; ?>

    <?php foreach (PRODUCTS as $p): ?>
      <figure class="rounded-3xl border-2 border-ink bg-white p-4">
        <img src="<?= e($p['photo']) ?>" alt="<?= e($p['name']) ?>" class="h-48 w-full rounded-2xl border-2 border-ink object-cover">
        <figcaption class="mt-3">
          <p class="font-display text-lg font-bold"><?= e($p['name']) ?> photo</p>
          <p class="text-sm text-cocoa">The card on the menu and the flavour popup.</p>
          <p class="mt-2 font-mono text-xs text-cocoa">data/products.php → <?= e($p['id']) ?></p>
          <p class="font-mono text-xs"><?= e($p['photo']) ?></p>
        </figcaption>
      </figure>
    <?php endforeach; ?>
  </div>

  <a href="index.php" class="mt-12 inline-block rounded-full border-2 border-ink bg-green px-6 py-3 font-semibold text-white hover:bg-greendk">Back to the shop</a>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

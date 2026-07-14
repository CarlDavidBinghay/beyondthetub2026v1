<?php
$pageTitle = 'Terms & privacy';
require __DIR__ . '/includes/header.php';
?>
<main class="mx-auto max-w-2xl px-5 py-14">
  <h1 class="font-display text-4xl font-bold">Terms &amp; privacy</h1>
  <p class="mt-2 text-cocoa">Short, because it should be. Last updated <?= date('j F Y') ?>.</p>

  <div class="mt-10 space-y-8 leading-relaxed">
    <section>
      <h2 class="font-display text-xl font-bold">Orders and stock</h2>
      <p class="mt-2 text-cocoa">This is a launch batch: twenty tubs per size, per flavour. The counter on the menu is the real number. When a size hits zero it is gone until we cook again — we do not hold tubs back.</p>
    </section>

    <section>
      <h2 class="font-display text-xl font-bold">Production dates</h2>
      <p class="mt-2 text-cocoa">You pick the date we cook your tubs. We need at least a day’s notice. If we ever have to move a date, we message you first and you can move with us or get a full refund.</p>
    </section>

    <section>
      <h2 class="font-display text-xl font-bold">Payment</h2>
      <p class="mt-2 text-cocoa">Pay online by scanning our QR — send the reference number and a screenshot so we can match it to your order. Or choose cash and pay on delivery or pickup; please prepare the exact amount.</p>
    </section>

    <section>
      <h2 class="font-display text-xl font-bold">Delivery and pickup</h2>
      <p class="mt-2 text-cocoa">Cebu only. Our rider covers the city and nearby areas for a flat fee; anywhere else, book your own rider and we hand the order over. Pickup is free and we send the exact pin once your order is in.</p>
    </section>

    <section>
      <h2 class="font-display text-xl font-bold">Changes and cancellations</h2>
      <p class="mt-2 text-cocoa">Message us at least 24 hours before your production date and we will move or refund the order. After that the ingredients are already bought, so we can move the date but not refund it.</p>
    </section>

    <section>
      <h2 class="font-display text-xl font-bold">Allergens and storage</h2>
      <p class="mt-2 text-cocoa">Both flavours contain wheat, dairy, egg and soy, and everything is made in one small kitchen on shared equipment. Keep tubs chilled and lidded; they last four days. Do not freeze them.</p>
    </section>

    <section>
      <h2 class="font-display text-xl font-bold">What we keep</h2>
      <p class="mt-2 text-cocoa">Your name, number, email, address and payment screenshot — only so we can cook your order, bring it to you, and confirm you paid. We do not sell any of it. Ask us to delete your details after your order and we will.</p>
    </section>
  </div>

  <a href="index.php" class="mt-12 inline-block rounded-full border-2 border-ink bg-green px-6 py-3 font-semibold text-white hover:bg-greendk">Back to the shop</a>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

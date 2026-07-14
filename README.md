# Beyond The Tub — PHP + Tailwind ordering system

Cebu-only launch shop: two flavours, two sizes, twenty tubs each. Browse, add to cart, pick a production date, choose delivery or pickup, pay online or cash, get a receipt. Plain procedural PHP with sessions — no Composer, no framework, no build step.

## Run it

1. Put the `beyondthetub` folder in `htdocs`.
2. Open `http://localhost/beyondthetub/`.
3. Make `storage/` writable: `chmod -R 775 storage`.

Admin: `http://localhost/beyondthetub/admin.php` — passcode `tub2026` (change it in `config.php`).

## Change these first

| What | Where |
|---|---|
| **Prices** — I used placeholders (8oz ₱170–180, 12oz ₱240–250) | `data/products.php` |
| **Pickup address + Maps link** — currently a placeholder | `config.php` → `PICKUP` |
| **Delivery fee** — currently ₱80 flat | `config.php` → `DELIVERY_METHODS` |
| **Admin passcode** | `config.php` → `ADMIN_CODE` |
| **Instagram / email** | `config.php` → `SHOP` |

## The images you sent

They are all in `assets/brand/`, mapped to slots in `config.php` → `ASSETS`. I had to guess which was which. Open **`assets.php`** in your browser — it shows every slot with the image currently in it. If one is wrong, change the filename in `config.php` (or in `data/products.php` for the two product photos). Nothing else needs editing.

Slots: `logo`, `hero`, `menu`, `qr` (shown at checkout for online payment), plus two spares.

## What it does

**Stock (your launch caps).** `LAUNCH_STOCK` in `config.php`: Biscoff 8oz 20, Biscoff 12oz 20, Classic 8oz 20, Classic 12oz 20. The live count lives in `storage/stock.json` and drops as orders come in. The menu shows "14 left" per size, the cart cannot exceed it, and a size that hits zero shows as sold out. If two people race for the last tub, the second one is told to adjust — the stock is taken server-side before the order is written. You can edit any count from admin.

**Production dates.** Fully changeable from admin — one date per line, `YYYY-MM-DD`. Those are the only dates customers can pick, and past ones drop off by themselves. Leave the list empty and the site offers the next 10 open days automatically.

**Delivery vs pickup.** Choosing delivery opens extra fields: complete address, city (Cebu list), landmark, who receives it, their number, optional Maps pin, notes for the rider. Choosing pickup hides all of that and shows the pickup location with an "Open in Google Maps" button — the same pin appears on the confirmation.

**Payment.** Online shows your QR, then asks for the reference number and a payment screenshot (JPG/PNG/WEBP, max 5MB, saved to `storage/proofs/` and shown in admin next to the order). Cash on delivery / on pickup skips both.

**Referral.** Every order asks how they heard about you, plus an optional "who referred you".

**Google Form.** The footer and menu link to your existing form as a backup way to order. To also copy every order *into* that form automatically, see below.

## Sending orders into your Google Form (optional)

1. Open your form → **Send** → link icon → or use *Get pre-filled link*, fill dummy answers, click **Get link**.
2. The link contains `entry.123456789=...` for each question. Note the number for each field.
3. Take the form ID from the URL and build the post URL: `https://docs.google.com/forms/d/e/FORM_ID/formResponse`.
4. Put both in `config.php` → `GOOGLE_FORM_SYNC`, set `'enabled' => true`.

Every order then posts to the form as well as saving locally. If it is off, the site just links to the form.

## Getting told when someone orders

By default nothing pings you — you have to open `admin.php`. Two ways to fix that.

**1. Leave `admin.php` open (zero setup).** The page watches for new orders every 20 seconds. When one lands it beeps, pops a desktop notification, and puts a count in the tab title. Click **Turn on alerts** once to let the browser show notifications. Good for launch day on a second screen.

**2. Push to your phone (recommended).** Fill in `config.php` → `NOTIFY`:

*Telegram — easiest, free, instant.*
1. In Telegram, message **@BotFather**, send `/newbot`, pick a name. It gives you a token like `123456:AAH...` → that's `telegram_token`.
2. Message **@userinfobot**. It replies with your numeric ID → that's `telegram_chat_id`.
3. Send your new bot any message once, so it's allowed to message you back.

Every order now arrives as a message: what they ordered, total, when, who, where, and whether it's cash or paid online.

*Discord — if you'd rather have a channel.* Server Settings → Integrations → New Webhook → copy the URL into `discord_webhook`.

*Email — `email_to`.* Works on a real host, usually **not** on XAMPP, since localhost has no mail server. Don't rely on it.

A dead notification service never blocks an order — if Telegram is down, the order still saves.

## Before it goes live

- Change `ADMIN_CODE` and put admin behind a real login.
- Delete `setup.php` — it reports your server's user and paths.
- Swap the Tailwind CDN for a built stylesheet: `npx tailwindcss -i in.css -o assets/tailwind.css --minify`.
- Run `setup.php` once after moving the folder — it checks permissions and prints the exact fix
- Block direct access to `storage/` in your web server config, or move it outside the web root — payment screenshots sit in there.
- Wire a mailer into `actions/order.php` if you want confirmation emails.

# Self-Hosting Guide: Cloudflare Tunnel

Output your local Laravel site to the world using your own domain, securely and for free.

## 1. Install Cloudflare Tunnel (`cloudflared`)

Run these commands in your terminal to install the tool:

```bash
# Download the package
curl -L --output cloudflared.deb https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64.deb

# Install it
sudo dpkg -i cloudflared.deb
```

## 2. Authenticate

This will open your browser to log in to Cloudflare and select your domain.

```bash
cloudflared tunnel login
```

- Select the domain you want to use (e.g., `ossaga.com`).
- Example: If you want your site at `love.ossaga.com`, just select `ossaga.com` here.

## 3. Create the Tunnel

Create a tunnel named `valentine`:

```bash
cloudflared tunnel create valentine
```

- **Copy the Tunnel ID** from the output (it looks like `UUID`, e.g., `a1b2c3d4-...`).

## 4. Configure DNS

Connect your domain (e.g., `valentine.yourdomain.com`) to this tunnel:

```bash
# Replace 'valentine.yourdomain.com' and 'UUID' with your actual details
cloudflared tunnel route dns valentine valentine.yourdomain.com
```

## 5. Run the Connection

Now, connect your local Laravel server to the tunnel.

**Step A: Start Laravel** (Keep this terminal open)

```bash
php artisan serve
```

**Step B: Start Tunnel** (Open a NEW terminal tab)

```bash
# Point the tunnel to your local backend
cloudflared tunnel run --url http://localhost:8000 valentine
```

## 6. Access the Site

Open `https://valentine.yourdomain.com` (or whatever domain you configured).
It should load your local Laravel site! 🚀

> **Note:** Both the `php artisan serve` and `cloudflared tunnel run` commands must stay running for the site to be online.

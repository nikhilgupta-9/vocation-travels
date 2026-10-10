# Vocation Travels - Hostinger Deployment & Production Setup Guide

Domain: `https://vocationtravels.in/`  
Instagram: `https://www.instagram.com/vocationtravels/`

---

## 🚀 Quick 3-Step Hostinger Deployment

### Step 1: Push Code to Git / Upload to Hostinger
1. Commit and push your latest code to your GitHub repository:
   ```bash
   git add .
   git commit -m "Production ready: Pan-India SEO, high-res visuals, and Hostinger htaccess"
   git push origin main
   ```
2. In Hostinger hPanel:
   - Go to **Advanced** > **GIT** (or File Manager).
   - Connect your GitHub repository `https://github.com/nikhilgupta-9/vocation-travels` to branch `main`.
   - Set deployment directory to: `/public_html`
   - Click **Deploy**.

---

### Step 2: Database Setup (1-Click Import)
1. In Hostinger hPanel, go to **Databases** > **MySQL Databases**.
2. Create a new database:
   - Database Name: `u123456789_vocation_db` (note down your full name)
   - Username: `u123456789_user`
   - Password: `YourStrongPassword!`
3. Open **phpMyAdmin** for this database.
4. Click **Import** > Choose file:  
   `database/vocation_travels_db.sql`  
5. Click **Go** (Import).  
   *(All 42+ Indian cities, tour packages, blogs, contacts & Instagram settings will be imported instantly).*

---

### Step 3: Configure `.env` File
In Hostinger File Manager (in `public_html`), create or edit `.env`:
```ini
DB_HOST=localhost
DB_USERNAME=u123456789_user
DB_PASSWORD=YourStrongPassword!
DB_NAME=u123456789_vocation_db
SITE=https://vocationtravels.in/
```

> **Note on URL Detection:** `config/connect.php` is now intelligent. Even if `SITE` is omitted, it auto-detects `https://vocationtravels.in/` when running live!

---

## 🛡️ Production & Security Features Included
* **No Broken Paths:** Hardcoded `RewriteBase` has been removed from `.htaccess`. Clean URLs (`/about`, `/travel-package`, `/visa-services`, `/visa-consultants-mumbai/`, etc.) work natively on both Hostinger and local environments.
* **Sensitive File Protection:** Direct web access to `.env`, `.git`, `.gitignore`, `composer.*`, and `.sql` files is blocked with `403 Forbidden`.
* **Automated HTTPS:** On `vocationtravels.in`, HTTP requests automatically redirect to secure HTTPS.
* **GZIP Compression & Asset Caching:** Faster PageSpeed score and bandwidth savings.
* **Floating WhatsApp & Quick Enquire:** WhatsApp button configured for high conversion rates.

---

## 📈 Pan-India Programmatic SEO (Tier 1, 2 & 3 Cities)
* Over 49+ Indian cities are indexed in `https://vocationtravels.in/sitemap.xml`:
  - **Metros:** Delhi NCR, Mumbai, Bengaluru, Hyderabad, Chennai, Kolkata, Pune, Ahmedabad
  - **North India:** Jaipur, Chandigarh, Lucknow, Kanpur, Ludhiana, Amritsar, Dehradun, Agra, Varanasi, Jodhpur, Meerut, Gwalior, Noida, Gurgaon, Shimla
  - **West & Central:** Surat, Vadodara, Rajkot, Nagpur, Nashik, Indore, Bhopal, Raipur, Goa
  - **South India:** Kochi, Coimbatore, Visakhapatnam, Vijayawada, Thiruvananthapuram, Madurai, Mysuru, Tiruchirappalli
  - **East & North East:** Patna, Ranchi, Bhubaneswar, Guwahati, Siliguri, Jamshedpur
* Any valid Indian city slug (e.g. `/visa-consultants-udaipur/`) dynamically generates an optimized landing page with local FAQs, breadcrumbs, and Schema.org markup.

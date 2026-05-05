# Hosting Your Laravel E-Commerce Project on InfinityFree

InfinityFree is a popular free hosting service that supports PHP and MySQL. However, hosting a Laravel application on shared hosting requires some specific adjustments because Laravel expects its "Document Root" to be the `public` folder, whereas InfinityFree uses `htdocs`.

Follow these steps carefully to get your site live.

---

## Prerequisites
- An active [InfinityFree](https://www.infinityfree.com/) account.
- **Optional**: A zip utility (like WinRAR, 7-Zip, or built-in Windows Zip).
- Your project is ready for production (all features tested locally).

---

## Step 1: Prepare Your Project Locally
Before uploading, you must optimize the application for production.

1.  **Compile Assets**:
    Run the following command to generate the final CSS and JS files:
    ```bash
    npm run build
    ```
2.  **Optimize Laravel**:
    Run these commands to cache your configuration and routes (this makes the site faster and prevents `.env` issues on some servers):
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
3.  **Create a ZIP File**:
    Select all files and folders in your project directory (except `.git` and `node_modules`) and compress them into a single file named `project.zip`.

---

## Step 2: Create a Database on InfinityFree
1.  Log in to your InfinityFree Client Area and click **Manage** on your account.
2.  Go to the **Control Panel**.
3.  Find the **Databases** section and click **MySQL Databases**.
4.  Create a new database (e.g., `ecommerce`).
5.  **Important**: Note down the following details from the MySQL Databases page:
    - **MySQL Hostname** (e.g., `sql123.epizy.com`)
    - **MySQL Username** (e.g., `epiz_12345678`)
    - **MySQL Password** (Your InfinityFree account password)
    - **Database Name** (e.g., `epiz_12345678_ecommerce`)

---

## Step 3: Upload and Extract (The Fast Way)
Instead of using FileZilla, we will use the Online File Manager to upload your zip file.

1.  Log in to your InfinityFree Client Area and go to the **Control Panel**.
2.  Click on **Online File Manager**.
3.  Navigate into the `htdocs` folder.
4.  Click the **Upload** button (usually an icon with an arrow pointing up) and select **Upload Zip**.
5.  Select your `project.zip` file.
6.  Once uploaded, the File Manager will ask if you want to **Unzip** it. Select **Yes**.
    *   *Note: If it doesn't ask, right-click the file and select "Extract".*
7.  Verify that all folders (`app`, `vendor`, `public`, etc.) are now directly inside `htdocs`.


---

## Step 4: Configure the Web Root
By default, InfinityFree looks for `index.php` in the `htdocs` folder. Laravel's `index.php` is inside the `public` folder. We need to redirect traffic.

1.  In the `htdocs` folder on the server, create a file named `.htaccess` (or edit the existing one).
2.  Add the following code:
    ```apache
    <IfModule mod_rewrite.c>
        RewriteEngine On
        # Redirect all traffic to the public folder
        RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>
    ```

---

## Step 5: Update the `.env` File
1.  Open the `.env` file you uploaded to the `htdocs` folder.
2.  Update the database details with the ones you noted in **Step 2**:
    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=http://your-subdomain.infinityfreeapp.com

    DB_CONNECTION=mysql
    DB_HOST=sql123.epizy.com  # Use YOUR actual hostname
    DB_PORT=3306
    DB_DATABASE=epiz_12345678_ecommerce
    DB_USERNAME=epiz_12345678
    DB_PASSWORD=your_password
    ```

---

## Step 6: Import Your Database
Since you cannot run `php artisan migrate` on InfinityFree:

1.  Open your local **phpMyAdmin**.
2.  Select your local database and click **Export**. Save the `.sql` file.
3.  Go to the InfinityFree **Control Panel** and open **phpMyAdmin**.
4.  Select your new InfinityFree database.
5.  Click **Import** and upload your `.sql` file.

---

## Step 7: Fix Permissions (If needed)
If you see a "Permission Denied" error or "Storage not writable":
1.  In the Online File Manager, navigate to the `storage` and `bootstrap/cache` folders.
2.  Right-click the folder and select **Permissions** (or CHMOD).
3.  Set them to `775` or `777` (Note: `775` is safer, but some free hosts require `777`).

---

## Common Troubleshooting
- **500 Internal Server Error**: Usually caused by a syntax error in `.htaccess` or an incompatible PHP version. Ensure your account is set to PHP 8.2 or higher in the Control Panel.
- **Vite/Manifest Not Found**: Make sure you ran `npm run build` locally and uploaded the `public/build` folder.
- **Database Connection Refused**: Double-check the **MySQL Hostname**. It is NOT `localhost` on InfinityFree.

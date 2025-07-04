
📌 Project Name: Goldfish Strategy

👨‍💻 Created by: Albu Péter

🎯 Purpose
This is a hobby project that allows users to track the total and invested value of their crypto portfolio.
It is not a financial advisory tool – it's built for demonstration and educational purposes, with example data.

⚠️ Disclaimer
❗ This project is not financial advice.
The displayed data is based on sample data only.
This tool does not guarantee accuracy in real-world prices or financial calculations.

🧩 Features
- Crypto portfolio value tracking (in USDC)
- Historical portfolio chart
- Coin prices fetched via CoinGecko API
- Tracks both net worth and total invested
- Multilingual UI (🇬🇧 🇭🇺 🇩🇪 🇫🇷)

🌐 Multilingual Support
The site is available in 4 languages:
- 🇭🇺 Hungarian
- 🇬🇧 English (default)
- 🇩🇪 German
- 🇫🇷 French

Multilingual support is implemented using data-translate attributes and JavaScript. Language switching works instantly without page reload.

🛠️ Installation and Usage

1. Install XAMPP
- Install and start Apache and MySQL

2. Place the project
- Copy the project folder to htdocs, e.g.: C:\xampp\htdocs\

3. Import the database
- Go to phpMyAdmin: http://localhost/phpmyadmin
- Create a database called 'goldfish-strategy.sql'
- Import the provided goldfish.sql file

4. Set up price API
- Ensure api/get-prices.php fetches current prices from CoinGecko

5. Open the site
- In browser: http://localhost/goldfish-strategy/

✅ Usage
- The portfolio is refreshed automatically
- The graph shows performance over time
- You can change languages in the UI
- Daily update is recommended (can be automated)

🔐 Admin Access
- Portfolio data can be entered via an admin interface
- Use the following credentials to log in:
  - Username: `admin`
  - Password: `admin`

🚀 Future Improvements
- Multi-user support (each user can have their own portfolio)
- Email notifications about portfolio changes
- More Coins
- Automated price updates via cron job

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        header { background: #9A7B4F; color: white; padding: 20px; text-align: center; }
        .container { display: grid; gap: 20px; padding: 20px; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
        .card { background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card h2 { margin: 15px; color: #333; }
        .card p { margin: 15px; color: #555; }
        .card a { display: inline-block; margin: 15px; color: #28A745; text-decoration: none; font-weight: bold; }
        .card a:hover { text-decoration: underline; }
        footer { text-align: center; padding: 10px; background: #f1f1f1; margin-top: 20px; }
    </style>
</head>
<body>
    <header>
        <h1>Blog</h1>
    </header>
    <main>
        <div class="container">
            <div class="card">
                <img src="use1.jpg" alt="Post 1">
                <h2>Top 5 Travel Destinations for 2025</h2>
                <p>Looking for your next adventure? Explore the top travel spots of 2025, from pristine beaches to bustling cities!</p>
                <a href="#">Read More</a>
            </div>
            
            <div class="card">
                <img src="use2.jpg" alt="Post 3">
                <h2>How Technology is Changing Hospitality</h2>
                <p>From smart rooms to AI concierge, discover how tech innovations are revolutionizing the guest experience.</p>
                <a href="#">Read More</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 <h1>Mövenpick</h1></p>
    </footer>
</body>
</html>

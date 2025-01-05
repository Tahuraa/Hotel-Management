<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Rooms</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        header { background: #9A7B4F; color: white; padding: 20px; text-align: center; }
        .container { display: grid; gap: 20px; padding: 20px; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
        .card { background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card h2 { margin: 15px; color: #333; }
        .card p { margin: 15px; color: #555; }
        footer { text-align: center; padding: 10px; background: #f1f1f1; margin-top: 20px; }
    </style>
</head>
<body>
    <header>
        <h1>Our Rooms</h1>
    </header>
    <main>
        <div class="container">
            <div class="card">
                <img src="superior.jpg" alt="Deluxe Room">
                <h2>Deluxe Room</h2>
                <p>Spacious and luxurious, perfect for families or couples.</p>
            </div>
            <div class="card">
                <img src="special.jpg" alt="Standard Room">
                <h2>Standard Room</h2>
                <p>Comfortable and affordable, ideal for solo travelers.</p>
            </div>
            <div class="card">
                <img src="sea.jpg" alt="Suite">
                <h2>Suite</h2>
                <p>Ultimate comfort with premium amenities and a private balcony.</p>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 <h1>Mövenpick</h1></p>
    </footer>
</body>
</html>

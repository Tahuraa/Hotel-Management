<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        header { background: #9A7B4F; color: white; padding: 20px; text-align: center; }
        section { display: flex; flex-wrap: wrap; justify-content: space-between; padding: 20px; }
        .text, .image { flex: 1 1 45%; margin: 10px; }
        .text { display: flex; flex-direction: column; justify-content: center; }
        .text h2 { color: #333; }
        .text p { color: #555; line-height: 1.6; }
        .image img { width: 100%; border-radius: 8px; }
        footer { text-align: center; padding: 10px; background: #f1f1f1; margin-top: 20px; }
    </style>
</head>
<body>
    <header>
        <h1>About Us</h1>
    </header>
    <main>
        <section>
            <div class="text">
                <h2>Who We Are</h2>
                <p>We are a dedicated team passionate about providing exceptional services to our clients. Our goal is to create unforgettable experiences.</p>
            </div>
            <div class="image">
                <img src="team.jpg" alt="Our Team">
            </div>
        </section>
        <section>
            <div class="image">
                <img src="mission.jpg" alt="Our Mission">
            </div>
            <div class="text">
                <h2>Our Mission</h2>
                <p>To deliver top-notch hospitality and ensure customer satisfaction through attention to detail and quality services.</p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 <h1>Mövenpick</h1></p>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Страница не найдена</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #1a2a6c);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            overflow: hidden;
            text-align: center;
            padding: 20px;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .container {
            max-width: 800px;
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }
        
        .not-found-title {
            font-size: 15rem;
            font-weight: 900;
            color: #4c9408;
            text-shadow: 0 0 20px rgba(76, 148, 8, 0.8);
            line-height: 1;
            margin-bottom: 20px;
            letter-spacing: 10px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { text-shadow: 0 0 20px rgba(76, 148, 8, 0.8); }
            50% { text-shadow: 0 0 40px rgba(76, 148, 8, 1), 0 0 60px rgba(76, 148, 8, 0.8); }
            100% { text-shadow: 0 0 20px rgba(76, 148, 8, 0.8); }
        }
        
        h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .home-btn {
            display: inline-block;
            background: #4c9408;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(0);
        }
        
        .home-btn:hover {
            background: #5bb209;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        
        .home-btn:active {
            transform: translateY(0);
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .not-found-title {
                font-size: 10rem;
            }
            
            h2 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .not-found-title {
                font-size: 7rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            p {
                font-size: 1rem;
            }
            
            .container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="not-found-title">404</h1>
        <h2>Ой! Страница потерялась</h2>
        <p>Извините, запрашиваемая страница не найдена. Возможно, она была перемещена или удалена. Проверьте правильность URL или вернитесь на главную страницу.</p>
        <a href="/" class="home-btn">На главную</a>
    </div>
</body>
</html>
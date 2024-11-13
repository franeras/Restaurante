<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Restaurante</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cmVzdGF1cmFudHxlbnwwfHwwfHx8MA%3D%3D');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #ffffff;
        }
        .login-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        .login-container h1 {
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #f8f9fa;
        }
        .form-control {
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
        }
        .btn-primary:hover {
            background-color: #ff5252;
            border-color: #ff5252;
        }
        .text-center {
            color: #adb5bd;
            margin-top: 1rem;
        }
        .text-center a {
            color: #f8f9fa;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container text-center">
        <h1>Bienvenido al Restaurante</h1>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
        
        </div>
    </div>


</body>
</html>

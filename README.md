## Instrucciones de instalación

Para instalar y configurar esta aplicación Laravel, sigue los siguientes pasos:

1. Clona el repositorio de GitHub:
   ```
   git clone https://github.com/oliverservin/holiing.git
   ```
2. Navega al directorio del proyecto:
   ```
   cd holiing
   ```
3. Instala las dependencias de Composer:
   ```
   composer install
   ```
4. Copia el archivo de entorno de ejemplo y genera una clave de aplicación:
   ```
   cp .env.example .env
   php artisan key:generate
   ```
5. Configura las variables de entorno en el archivo `.env` para tu entorno de desarrollo.

6. Ejecuta las migraciones de la base de datos:
   ```
   php artisan migrate
   ```
7. Sirve la aplicación utilizando el servidor de desarrollo de Laravel:
   ```
   php artisan serve
   ```
Ahora deberías poder acceder a la aplicación en `http://localhost:8000`.

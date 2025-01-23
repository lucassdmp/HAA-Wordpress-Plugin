@echo off

:: Navigate to the plugin directory
cd "C:\Users\lucas\Downloads\Plugins\Helene Abiassy Academy Plugin"

:: Run composer dump-autoload
composer dump-autoload

:: Wait for 2 seconds
timeout /t 2 >nul

:: Go back to the parent directory
cd ..

:: Use tar to compress the folder into a zip file
tar -a -c -f "Helene Abiassy Academy Plugin.zip" "Helene Abiassy Academy Plugin"

echo Done!
pause

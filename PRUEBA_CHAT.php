<?php
require 'vendor/autoload.php';
use MarufMax\TelegramBot\Telegram;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>EmojiButton Example</title>
    <!-- Incluye la biblioteca EmojiButton -->
    <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4"></script>
  </head>
  <body>
    <textarea id="message-input" placeholder="Escribe tu mensaje aquí"></textarea>
    <button id="emoji-button">😀</button>

    <script>
      // Crea una instancia de EmojiButton
      const picker = new EmojiButton();

      // Encuentra el elemento del botón y el área de texto
      const trigger = document.querySelector('#emoji-button');
      const input = document.querySelector('#message-input');

      // Cuando se selecciona un emoji, agrega el emoji al área de texto
      picker.on('emoji', emoji => {
        input.value += emoji;
      });

      // Cuando se hace clic en el botón, muestra el selector de emojis
      trigger.addEventListener('click', () => picker.togglePicker(trigger));
    </script>
  </body>
</html>

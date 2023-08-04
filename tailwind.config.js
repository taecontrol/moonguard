import preset from './vendor/filament/filament/tailwind.config.preset';

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
  content: ['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php'],
};

# Laravel VanillaJS DataTable

A collection of live demos with Bootrrap and Tailwind themes and real-world examples using [`vanillajs-datatable`](https://www.npmjs.com/package/vanillajs-datatable).

[![npm version](https://img.shields.io/npm/v/vanillajs-datatable)](https://www.npmjs.com/package/vanillajs-datatable)
[![bundle size](https://img.shields.io/bundlephobia/minzip/vanillajs-datatable)](https://bundlephobia.com/package/vanillajs-datatable)

## Installation

### Using NPM

```bash
npm install vanillajs-datatable

//resources/js/app.js

import DataTable from "vanillajs-datatable";
window.DataTable = DataTable; // Make DataTable globally accessible

const table = new DataTable({
  // config options
});
```

### Included Demo Variants

-   Tailwind (default Laravel) — built-in Laravel Tailwind styling.

-   Bootstrap CDN — includes Bootstrap 5 via CDN and themed accordingly.

-   Alpine.js — shows how the table works inside Alpine components.

vanillajs-datatable-demo/
├── tailwind.blade.php # Tailwind + Laravel Demo
├── bootstrap.blade.php # Bootstrap 5 CDN + Blade Demo
├── alpine.blade.php # Alpine.js + Blade Demo

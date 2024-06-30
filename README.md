### Animal Care - Proyecto

<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</a>
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions">
<img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
</a>
<a href="https://packagist.org/packages/laravel/framework">
<img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/laravel/framework">
<img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/laravel/framework">
<img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
</a>
</p>

## Descripción del Proyecto

**Animal Care** es un sistema de gestión integral desarrollado con Laravel que está diseñado para facilitar la administración de albergues de animales. Este proyecto proporciona una plataforma completa que incluye funcionalidades para la gestión de adopciones, control de animales, registro de donantes, administración de patología y vacunación de los animales, entre otras características.

## Características Principales

- **Gestión de Adopciones:** Facilita el proceso de adopción de animales, incluyendo el registro y seguimiento de adoptantes.
- **Control de Albergues:** Permite la administración eficiente de los albergues, incluyendo la gestión de recursos y la asignación de animales.
- **Registro de Donantes:** Administra los datos de los donantes y sus contribuciones.
- **Gestión de Patologías y Vacunas:** Registra y sigue el historial médico de los animales, incluyendo patologías y vacunas.
- **Reportes y Estadísticas:** Genera reportes detallados y estadísticas para el análisis y toma de decisiones.

## Instalación

Para instalar y ejecutar el proyecto en un entorno local, siga estos pasos:

1. Clonar el repositorio:
   ```sh
   git clone https://github.com/alejandrohndz09/animal_care.git
   cd animal_care
   ```

2. Instalar las dependencias:
   ```sh
   composer install
   npm install
   ```

3. Configurar el archivo `.env`:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. Migrar la base de datos:
   ```sh
   php artisan migrate
   ```

5. Ejecutar el servidor de desarrollo:
   ```sh
   php artisan serve
   npm run dev
   ```

## Contribuciones

¡Las contribuciones son bienvenidas! Si desea contribuir a este proyecto, por favor, siga las siguientes pautas:

1. Realice un fork del repositorio.
2. Cree una nueva rama para sus cambios (`git checkout -b feature/nueva-funcionalidad`).
3. Realice sus cambios y agregue los commits correspondientes (`git commit -m 'Agregada nueva funcionalidad'`).
4. Haga push a la rama (`git push origin feature/nueva-funcionalidad`).
5. Cree un Pull Request en GitHub.

## Licencia

Este proyecto está licenciado bajo la licencia MIT. Consulte el archivo [LICENSE](LICENSE) para obtener más información.

---

Para obtener más información sobre los planes de suscripción y aumentar su cuota, puede seguir el siguiente enlace: [Planes de Suscripción](https://c7d59216ee8ec59bda5e51ffc17a994d.auth.portal-pluginlab.ai/pricing).

### Useful URLs

Documentation: [https://docs.askthecode.ai](https://docs.askthecode.ai) 
Github: [https://github.com/askthecode/documentation](https://github.com/askthecode/documentation) 
Twitter: [https://twitter.com/askthecode_ai](https://twitter.com/askthecode_ai)

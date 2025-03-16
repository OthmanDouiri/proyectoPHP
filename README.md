# Plataforma de Venta de Teléfonos (Pago Contra Entrega)

Una plataforma web para navegar y comprar teléfonos con el método de pago contra entrega (COD). La plataforma ofrece una interfaz intuitiva, segura y responsiva para que tanto los usuarios como los administradores gestionen productos, pedidos y usuarios. Este proyecto incorpora características como autenticación con JWT, internacionalización (i18n), visualización gráfica avanzada con Highcharts y Web Scraping usando Python y Selenium.

---

## Tecnologías Utilizadas

### Backend

- **PHP**: El lenguaje de programación del lado del servidor utilizado para construir la lógica del backend.
- **PDO (PHP Data Objects)**: Una capa de acceso a la base de datos segura y eficiente.
- **MySQL**: Sistema de gestión de bases de datos relacional para almacenar los datos de productos, usuarios y pedidos.
- **Composer**: Herramienta de gestión de dependencias de PHP para instalar y gestionar paquetes de PHP.
- **JWT (JSON Web Token)**: Utilizado para la autenticación y autorización segura de usuarios.
- **Apache**: El servidor web que aloja la aplicación.
- **XAMPP**: Un entorno de desarrollo local que agrupa Apache, MySQL y PHP.

### Frontend

- **HTML5**: El lenguaje de marcado utilizado para estructurar las páginas web.
- **CSS3**: Utilizado para el diseño y estilo de las páginas, asegurando un enfoque mobile-first y responsive.
- **JavaScript**: Scripting del lado del cliente para la interacción dinámica y contenido interactivo.
- **Bootstrap**: Un framework front-end responsive para el diseño y estilo móvil.
- **Twig**: Motor de plantillas utilizado para renderizar contenido dinámico en el frontend.
- **Highcharts**: Una biblioteca gráfica utilizada para crear gráficos interactivos y visualmente atractivos (por ejemplo, gráficos de tipo pie).

### Web Scraping

- **Python**: Lenguaje de programación utilizado para el web scraping.
- **Selenium**: Biblioteca de Python utilizada para la automatización de la navegación web y extracción de datos de sitios externos.

### Internacionalización (i18n)

- **i18n**: Habilita el soporte multilingüe cargando archivos de idiomas y traducciones dinámicamente, proporcionando una experiencia internacionalizada para usuarios de diferentes regiones.

---

## Características

- **Interfaz Amigable para el Usuario**: Navegación fácil para explorar y comprar teléfonos.
- **Pago Contra Entrega (COD)**: Permite a los usuarios seleccionar el pago contra entrega como método de pago.
- **Diseño Responsive**: Diseño completamente responsive que funciona en todos los tamaños de pantalla.
- **Categorías de Productos**: Los teléfonos están organizados en categorías para una fácil navegación.
- **Carrito de Compras**: Añadir/eliminar teléfonos del carrito y proceder a la compra.
- **Panel de Administración**: Interfaz para que los administradores gestionen productos, pedidos y usuarios.
- **Autenticación de Usuarios**: Inicio de sesión y registro seguro con JWT para gestionar las sesiones de usuario.
- **API para Teléfonos**: API RESTful para gestionar datos de teléfonos (agregar, actualizar, eliminar teléfonos).
- **Visualización Gráfica de Datos**: Uso de **Highcharts** para presentar datos de productos y pedidos visualmente (por ejemplo, gráficos de tipo pie).
- **Web Scraping**: Automatización y extracción de datos de sitios externos usando **Python** y **Selenium**.


## Instalación

Para poner en marcha el proyecto localmente, sigue estos pasos:

### 1. Clonar el Repositorio

Clona este repositorio en tu máquina local:

```bash
git clone https://github.com/yourusername/phone-selling-platform.git
```

### 2. Instalar Dependencias

Instala las dependencias necesarias de PHP utilizando Composer:

```bash
composer install
```

### 3. Configurar la Base de Datos

1. Importa el archivo `database.sql` en tu base de datos MySQL.
2. Actualiza la configuración de la conexión a la base de datos en `config/database.php`.

### 4. Configurar la Autenticación JWT

- La clave secreta JWT debe ser configurada en el archivo `.env` (o en otro archivo de configuración).
- Asegúrate de que el encabezado `Authorization` se pase correctamente en las rutas protegidas.

### 5. Instalar Dependencias de Web Scraping (Python y Selenium)

Si necesitas ejecutar el script de web scraping, asegúrate de tener Python y Selenium instalados:

1. Instala las dependencias de Python:
   ```bash
   pip install selenium
   ```

2. Descarga un controlador de navegador (por ejemplo, ChromeDriver) compatible con tu versión de navegador. 

3. Ejecuta los scripts de Python para extraer los datos necesarios de los sitios externos.

### 6. Iniciar el Servidor de Desarrollo

- Si estás utilizando **XAMPP**, asegúrate de que Apache y MySQL estén en ejecución.
- Coloca los archivos del proyecto en la carpeta `htdocs` (o equivalente) de tu instalación de XAMPP.
- Abre el proyecto en tu navegador en `http://localhost/phone-selling-platform`.

---

## Documentación de la API

La plataforma incluye una API RESTful para gestionar los datos de teléfonos. Los siguientes puntos finales están disponibles:

### **GET /api/phones**

Obtiene la lista de todos los teléfonos.

```bash
GET /api/phones
```

### **POST /api/phones**

Agrega un nuevo teléfono al catálogo.

```bash
POST /api/phones
```

Cuerpo:
```json
{
  "name": "iPhone 13",
  "category": "Smartphone",
  "price": 999,
  "stock": 50
}
```

### **PUT /api/phones/{id}**

Actualiza los detalles de un teléfono existente.

```bash
PUT /api/phones/{id}
```

Cuerpo:
```json
{
  "price": 899,
  "stock": 100
}
```

### **DELETE /api/phones/{id}**

Elimina un teléfono del catálogo.

```bash
DELETE /api/phones/{id}
```

---

## Uso

1. **Abre la plataforma** en tu navegador.
2. Navega por los teléfonos disponibles.
3. Añade el teléfono deseado al carrito y procede al pago.
4. Selecciona **Pago Contra Entrega (COD)** como tu método de pago.
5. Confirma tu pedido y espera la entrega.

---

## Datos Gráficos (Highcharts)

La plataforma utiliza **Highcharts** para proporcionar visualizaciones gráficas interactivas, como gráficos de tipo pie. Por ejemplo, los administradores pueden ver datos como la distribución de ventas de teléfonos o distribución del stock en formato de gráfico de pastel.

```javascript
Highcharts.chart('container', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Distribución de Ventas de Teléfonos'
    },
    series: [{
        name: 'Ventas',
        colorByPoint: true,
        data: [{
            name: 'iPhone 13',
            y: 50
        }, {
            name: 'Samsung Galaxy S21',
            y: 30
        }, {
            name: 'OnePlus 9',
            y: 20
        }]
    }]
});
```

---

## Web Scraping

La plataforma también utiliza **Python** con **Selenium** para realizar web scraping y extraer datos de sitios externos relacionados con teléfonos, como precios, características y stock. Los datos extraídos pueden ser utilizados para mantener el catálogo de productos actualizado o para obtener información adicional sobre los productos.

### Instrucciones para Web Scraping:

1. **Ejecutar el script de Python** para realizar scraping de los datos de teléfonos desde un sitio web externo.

2. **Automatización con Selenium**: El script navega por el sitio web y extrae la información relevante como nombre, precio, y detalles del producto.

---

## Contribuir

¡Te damos la bienvenida para contribuir! Para contribuir al proyecto, sigue estos pasos:

1. **Haz un fork del repositorio**.
2. **Crea una nueva rama**:
   ```bash
   git checkout -b feature/tu-nueva-característica
   ```
3. **Realiza los cambios** y haz commit:
   ```bash
   git commit -am 'Añadir nueva característica o corregir error'
   ```
4. **Sube los cambios a tu fork**:
   ```bash
   git push origin feature/tu-nueva-característica
   ```
5. **Crea un pull request** con una descripción detallada de los cambios realizados.

---

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

## Contacto

Si tienes preguntas o comentarios, no dudes en ponerte en contacto con [tu dirección de correo electrónico].

---

## Hoja de Ruta del Proyecto

- **V1.0**: Lanzamiento inicial con funciones básicas (catálogo de teléfonos, pago COD, carrito de compras).
- **V1.1**: Autenticación con JWT y sistema de inicio de sesión de usuarios.
- **V2.0**: Mejora de las visualizaciones gráficas de datos usando Highcharts (gráficos de pastel, etc.).
- **V3.0**: Internacionalización (i18n) para múltiples idiomas.
- **Futuro**: Ampliar la API para soportar más funcionalidades de gestión de datos, como perfiles de usuarios y reseñas.
```

---

### Cambios Clave:
1. **Web Scraping con Python y Selenium**: Añadí detalles sobre el uso de Python y Selenium para realizar web scraping de productos de teléfonos desde sitios externos.
2. **Actualización de la sección de instalación** para incluir instrucciones sobre cómo instalar Selenium y ejecutar scripts de scraping.

¡Si tienes más preguntas o necesitas algo más, no dudes en decírmelo!



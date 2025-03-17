# 📱 Phone Phony Plataforma de Venta de Teléfonos (Pago Contra Entrega)

Una plataforma web para navegar y comprar teléfonos con el método de pago contra entrega (COD). La plataforma ofrece una interfaz intuitiva, segura y responsiva para que tanto los usuarios como los administradores gestionen productos, pedidos y usuarios. Este proyecto incorpora características como autenticación con JWT, internacionalización (i18n), visualización gráfica avanzada con Highcharts y Web Scraping usando Python y Selenium.

---

## ⚙️ Tecnologías Utilizadas

### 💻 Backend

- **PHP**: El lenguaje de programación del lado del servidor utilizado para construir la lógica del backend.
- **PDO (PHP Data Objects)**: Una capa de acceso a la base de datos segura y eficiente.
- **MySQL**: Sistema de gestión de bases de datos relacional para almacenar los datos de productos, usuarios y pedidos.
- **Composer**: Herramienta de gestión de dependencias de PHP para instalar y gestionar paquetes de PHP.
- **JWT (JSON Web Token)**: Utilizado para la autenticación y autorización segura de usuarios.
- **Apache**: El servidor web que aloja la aplicación.
- **XAMPP**: Un entorno de desarrollo local que agrupa Apache, MySQL y PHP.

### 🌐 Frontend

- **HTML5**: El lenguaje de marcado utilizado para estructurar las páginas web.
- **CSS3**: Utilizado para el diseño y estilo de las páginas, asegurando un enfoque mobile-first y responsive.
- **JavaScript**: Scripting del lado del cliente para la interacción dinámica y contenido interactivo.
- **Bootstrap**: Un framework front-end responsive para el diseño y estilo móvil.
- **Twig**: Motor de plantillas utilizado para renderizar contenido dinámico en el frontend.
- **Highcharts**: Una biblioteca gráfica utilizada para crear gráficos interactivos y visualmente atractivos (gráficos de tipo pie).
- **GSAP**: Biblioteca de animaciones de alto rendimiento para crear efectos visuales fluidos y dinámicos en la web.

### 🤖 Web Scraping

- **Python**: Lenguaje de programación utilizado para el web scraping.
- **Selenium**: Biblioteca de Python utilizada para la automatización de la navegación web y extracción de datos de sitios externos.

### 🌐 Internacionalización (i18n)

- **i18n**: Habilita el soporte multilingüe cargando archivos de idiomas y traducciones dinámicamente, proporcionando una experiencia internacionalizada para usuarios de diferentes regiones.

---

## ✨ Características

- **Interfaz Amigable para el Usuario**: Navegación fácil para explorar y comprar teléfonos.
- **Pago Contra Entrega (COD)**: Permite a los usuarios seleccionar el pago contra entrega como método de pago.
- **Diseño Responsive**: Diseño completamente responsive que funciona en todos los tamaños de pantalla.
- **Categorías de Productos**: Los teléfonos están organizados en categorías para una fácil navegación.
- **Carrito de Compras**: Añadir/eliminar teléfonos del carrito y proceder a la compra.
- **Panel de Administración**: Interfaz para que los administradores gestionen productos, pedidos y usuarios.
- **Autenticación de Admin**: Inicio de sesión y registro seguro con JWT para gestionar las sesiones de Admin.
- **API para Teléfonos**: API para gestionar datos de teléfonos (agregar, actualizar, eliminar teléfonos).
- **Visualización Gráfica de Datos**: Uso de **Highcharts** para presentar datos de teléfonos (gráficos de tipo pie).
- **Web Scraping**: Automatización y extracción de datos de sitios externos usando **Python** y **Selenium**.


## 📝 Instalación

Para poner en marcha el proyecto localmente, sigue estos pasos:

### 1. 📂 Clonar el Repositorio

Clona este repositorio en tu máquina local:

```bash
git clone https://github.com/OthmanDouiri/proyectoPHP.git
```

### 2. ⚙️ Instalar Dependencias

Instala las dependencias necesarias de PHP utilizando Composer:

```bash
composer install
```

### 3. 📚 Configurar la Base de Datos

1. Importa el archivo `database.sql`que esta en la carpeta **db** en tu base de datos MySQL.
2. Actualiza la configuración de la conexión a la base de datos en `/src/controller/DatabaseController.php`.

### 4. 🔑 Configurar la Autenticación JWT

- La clave secreta JWT debe ser configurada en el archivo `/src/utils/JWTUtils.php` .
- Asegúrate de que el encabezado `Authorization` se pase correctamente en las rutas protegidas.

### 5. 🛠️ Instalar Dependencias de Web Scraping (Python y Selenium)

Si necesitas ejecutar el script de web scraping, aqui te dejo mi fichero webScraping.md para hacerlo paso a paso : 
[Python Selenium (webScraping)](webScraping.md)


### 6. 🔄 Iniciar el Servidor de Desarrollo

1- Utilizando **XAMPP**, asegúrate de que Apache y MySQL estén en ejecución.
2- Coloca los archivos del proyecto en la carpeta `htdocs` de tu instalación de XAMPP.
3- Abre el proyecto en tu navegador en `http://localhost/proyectophp`.


si quieres configurar tu proyecto utilizando **Virtual Hosts** en XAMPP para que puedas acceder a tu proyecto usando un nombre de **dominio.local**, en lugar de usar http://localhost/miProyecto. Aquí tienes una guía para configurar Virtual Hosts en XAMPP:
[Virtual Hosts](VirtualHosts.md)

---

## 📚 Documentación de la API

La plataforma incluye una API para gestionar los datos de teléfonos. Los siguientes puntos finales están disponibles:

### **/api/phones**
```bash
GET api/phones: Recupera una lista de phones
GET api/phones/{id}: Recupera un phone específico por su ID
POST api/phones: Crea un nuevo phone
PUT api/phones/{id}: Actualiza todos los datos de un phone específico
PATCH api/phones/{id}: Modifica parcialmente los datos de un phone
DELETE api/phones/{id}: Elimina un phone específico

```


---

## 🤖 Uso

1. **Abre la plataforma** en tu navegador.
2. Navega por los teléfonos disponibles.
3. Añade el teléfono deseado al carrito y procede al pago.
4. **Pago Contra Entrega (COD)** como tu método de pago.
5. Confirma tu pedido y espera la entrega.

---

## 📊 Datos Gráficos (Highcharts)

La plataforma utiliza **Highcharts** para proporcionar visualizaciones gráficas interactivas, como gráficos de tipo pie. Por ejemplo, los administradores pueden ver datos como la distribución de ventas de teléfonos o distribución del stock en formato de gráfico de pastel.

```javascript
Highcharts.chart('brandPieChart', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Distribución de marcas de móviles'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Porcentaje',
                        colorByPoint: true,
                        data: chartData
                    }]
                });
```


## 📞 Contacto

Si tienes preguntas o comentarios, no dudes en ponerte en contacto con [othman.douiri1@gmail.com].

---





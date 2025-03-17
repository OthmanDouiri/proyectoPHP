# from selenium import webdriver
# from selenium.webdriver.chrome.service import Service
# from selenium.webdriver.chrome.options import Options
# from selenium.webdriver.common.by import By
# import mysql.connector


# # Conexión a la base de datos
# con = mysql.connector.connect(
#     host="localhost",
#     user="root",
#     password="",
#     database="auth_db"
# )
# cursor = con.cursor()

# # Configurar opciones de Chromium
# chrome_options = Options()
# chrome_options.binary_location = "/usr/bin/chromium-browser"  # Ruta de Chromium

# # Configurar ChromeDriver
# service = Service("/usr/bin/chromedriver")  # Ruta de ChromeDriver

# # Inicializar WebDriver
# driver = webdriver.Chrome(service=service, options=chrome_options)

# # URL de Amazon
# url = "https://www.amazon.es/moviles-iphone/s?k=moviles+iphone"
# driver.get(url)

# # Encontrar todos los productos en la página
# products = driver.find_elements(By.CLASS_NAME, "puis-card-container")

# # Contador para limitar el número de productos procesados
# product_count = 0
# max_products = 20  # Número máximo de productos a procesar

# # Iterar sobre los productos para obtener el nombre, el precio y la imagen
# for product in products:
#     if product_count >= max_products:  # Detener el bucle si se alcanzan 20 productos
#         break

#     try:
#         # Inicializar variables como `None` por defecto
#         name = None
#         price = None
#         image_url = None

#         # Extraer el nombre del producto
#         try:
#             name = product.find_element(By.CLASS_NAME, "a-size-base-plus").text
#         except Exception:
#             print("Nombre no encontrado.")

#         # Extraer el precio del producto
#         try:
#             price = product.find_element(By.CLASS_NAME, "a-price-whole").text
#             # Añadir el símbolo € si no está presente
#             if not price.endswith("€"):
#                 price += "€"
#         except Exception:
#             print("Precio no encontrado.")

#         # Extraer la URL de la imagen del producto
#         try:
#             image_url = product.find_element(By.CLASS_NAME, "s-image").get_attribute("src")
#         except Exception:
#             print("URL de la imagen no encontrada.")

#         # Comprobar si todos los valores son válidos antes de insertar en la base de datos
#         if name and price and image_url:
#             print(f"Producto: {name}, Precio: {price}, Imagen URL: {image_url}")
#             cursor.execute(
#                 "INSERT INTO phone (name, price, image_url) VALUES (%s, %s, %s)",
#                 (name, price, image_url)
#             )
#             con.commit()
#             product_count += 1  # Incrementar el contador solo si el producto se añadió correctamente
#         else:
#             print("Producto no válido (falta algún valor), no se añadirá a la base de datos.")
#     except Exception as e:
#         print("Error al procesar el producto:", e)

# # Cerrar la conexión a la base de datos
# cursor.close()
# con.close()

# # Cerrar el navegador
# driver.quit()

import time
import random
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
import mysql.connector

#  Configurar conexión a la base de datos
con = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="auth_db2"
)
cursor = con.cursor()

#  Configurar opciones de Selenium
chrome_options = Options()
chrome_options.add_argument("--headless")  # Ejecutar sin abrir ventana (opcional)
chrome_options.add_argument("--disable-gpu")  
chrome_options.add_argument("--no-sandbox")  
chrome_options.add_argument("--disable-dev-shm-usage")  
chrome_options.add_argument("--window-size=1920x1080")  

# Simular un navegador real para evitar bloqueos
chrome_options.add_argument(
    "user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
)

# Ruta correcta de ChromeDriver en Windows
service = Service(r"C:\Users\Othman\Desktop\WebScraping\chromedriver.exe")

#  Inicializar WebDriver
driver = webdriver.Chrome(service=service, options=chrome_options)

#  URL de Amazon
url = "https://www.amazon.es/s?k=moviles+iphone"
driver.get(url)

#  Esperar unos segundos para evitar bloqueos (simula comportamiento humano)
time.sleep(random.uniform(2, 5))

#  Encontrar todos los productos en la página
products = driver.find_elements(By.CSS_SELECTOR, ".s-result-item.s-asin")

#  Contador para limitar el número de productos procesados
product_count = 0
max_products = 20  # Número máximo de productos a procesar

#  Iterar sobre los productos
for product in products:
    if product_count >= max_products:  # Detener el bucle si se alcanzan 20 productos
        break

    try:
        # Inicializar variables como `None`
        name = None
        price = None
        image_url = None

        # Extraer el nombre del producto
        try:
            name = product.find_element(By.CSS_SELECTOR, "h2 span").text
        except Exception:
            print("Nombre no encontrado.")

        # Extraer el precio del producto
        try:
            price = product.find_element(By.CSS_SELECTOR, ".a-price-whole").text
            if not price.endswith("€"):
                price += "€"
        except Exception:
            print("Precio no encontrado.")

        # Extraer la URL de la imagen del producto
        try:
            image_url = product.find_element(By.CSS_SELECTOR, ".s-image").get_attribute("src")
        except Exception:
            print("URL de la imagen no encontrada.")

        #  Comprobar si todos los valores son válidos antes de insertar en la base de datos
        if name and price and image_url:
            print(f"Producto: {name}, Precio: {price}, Imagen URL: {image_url}")
            cursor.execute(
                "INSERT INTO phone (name, price, image_url) VALUES (%s, %s, %s)",
                (name, price, image_url)
            )
            con.commit()
            product_count += 1  # Incrementar el contador solo si el producto se añadió correctamente
        else:
            print("Producto no válido (falta algún valor), no se añadirá a la base de datos.")

        #  Espera aleatoria entre cada iteración para evitar bloqueos
        time.sleep(random.uniform(2, 5))

    except Exception as e:
        print("Error al procesar el producto:", e)

#  Cerrar la conexión a la base de datos
cursor.close()
con.close()

#  Cerrar el navegador
driver.quit()


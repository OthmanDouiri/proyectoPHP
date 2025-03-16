Guía para configurar **Virtual Hosts** en XAMPP:

### Paso 1: Editar el archivo `httpd-vhosts.conf`

1. **Localiza el archivo `httpd-vhosts.conf`**:
   - En la instalación de XAMPP, ve a la carpeta de configuración de Apache:
     - En Windows: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
     - En macOS: `/Applications/XAMPP/xamppfiles/etc/extra/httpd-vhosts.conf`

2. **Abrir el archivo `httpd-vhosts.conf`**:
   - Abre este archivo con un editor de texto (como Notepad++ o Visual Studio Code).

3. **Agregar la configuración del Virtual Host**:
   - Al final del archivo, añade una entrada para tu proyecto. La estructura es la siguiente:
     ```apache
     <VirtualHost *:80>
         DocumentRoot "C:/xampp/htdocs/miProyecto"
         ServerName miProyecto.local
         <Directory "C:/xampp/htdocs/miProyecto">
             AllowOverride All
             Require all granted
         </Directory>
     </VirtualHost>
     ```
   - Reemplaza `C:/xampp/htdocs/miProyecto` con la ruta correcta donde está tu proyecto en la carpeta `htdocs`.
   - En este ejemplo, el dominio local será `miProyecto.local`, pero puedes poner cualquier nombre de dominio que prefieras.

### Paso 2: Configurar el archivo `hosts`

1. **Editar el archivo `hosts`**:
   - En **Windows**, el archivo `hosts` se encuentra en `C:\Windows\System32\drivers\etc\hosts`.
   - En **macOS** o **Linux**, el archivo `hosts` está en `/etc/hosts`.

2. **Agregar una entrada para el Virtual Host**:
   - Abre el archivo `hosts` con permisos de administrador (en macOS o Linux, usa `sudo`).
   - Al final del archivo, agrega la siguiente línea:
     ```text
     127.0.0.1 miProyecto.local
     ```
   - Esto redirige cualquier solicitud a `miProyecto.local` a tu máquina local (localhost).

### Paso 3: Editar el archivo `httpd.conf` de Apache

1. **Localiza el archivo `httpd.conf`**:
   - En **Windows**, el archivo se encuentra en `C:\xampp\apache\conf\httpd.conf`.
   - En **macOS**, se encuentra en `/Applications/XAMPP/xamppfiles/etc/httpd.conf`.

2. **Descomentar la línea `Include conf/extra/httpd-vhosts.conf`**:
   - Busca la siguiente línea en el archivo `httpd.conf`:
     ```apache
     #Include conf/extra/httpd-vhosts.conf
     ```
   - Descomenta esta línea eliminando el `#` al principio de la línea:
     ```apache
     Include conf/extra/httpd-vhosts.conf
     ```
   - Esto asegura que Apache cargue la configuración de los Virtual Hosts.

### Paso 4: Reiniciar Apache

1. **Reiniciar Apache**:
   - Vuelve al **XAMPP Control Panel** y haz clic en **Stop** junto a Apache, y luego en **Start** nuevamente para reiniciar el servicio de Apache.

### Paso 5: Probar la configuración

1. **Abrir el navegador**:
   - Ahora abre tu navegador y escribe en la barra de direcciones `http://miProyecto.local` (o el nombre de dominio que hayas elegido).
   
2. **Verifica que tu proyecto cargue**:
   - Si todo está configurado correctamente, deberías ver tu proyecto funcionando a través de la URL `http://miProyecto.local`.

### Resumen de pasos:
1. Editar `httpd-vhosts.conf` para agregar tu Virtual Host.
2. Modificar el archivo `hosts` para mapear `miProyecto.local` a `127.0.0.1`.
3. Asegúrate de que `httpd.conf` tenga la línea correcta para cargar `httpd-vhosts.conf`.
4. Reiniciar Apache.
5. Acceder a tu proyecto en `http://miProyecto.local`.


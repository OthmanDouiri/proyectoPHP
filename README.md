# proyectoPHP
Para establecer una relación entre las tablas `phone` y `marca`, puedes usar un esquema en el que cada teléfono tenga una referencia a su marca. A continuación, te explico cómo diseñar esto paso a paso en SQL:

### 1. **Crear la tabla `marca`**
La tabla `marca` tendrá al menos dos columnas: `id` (clave primaria) y `nombre` (nombre de la marca). 

```sql
CREATE TABLE marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);
```

### 2. **Actualizar la tabla `phone` para incluir la relación**
Añade una columna `marca_id` en la tabla `phone` para vincular cada teléfono con su marca. Esta columna será una clave foránea que apunte a la tabla `marca`.

```sql
ALTER TABLE phone
ADD COLUMN marca_id INT,
ADD CONSTRAINT fk_phone_marca
FOREIGN KEY (marca_id) REFERENCES marca(id);
```

### 3. **Ejemplo de datos**
- Insertar marcas en la tabla `marca`:

```sql
INSERT INTO marca (nombre) VALUES 
('Samsung'),
('Apple'),
('Xiaomi'),
('Huawei');
```

- Insertar teléfonos en la tabla `phone` vinculados a una marca:

```sql
INSERT INTO phone (nombre, precio, marca_id) VALUES 
('Galaxy S23', 799, 1), -- Samsung
('iPhone 14', 999, 2), -- Apple
('Redmi Note 12', 249, 3), -- Xiaomi
('P50 Pro', 699, 4); -- Huawei
```

### 4. **Consultas comunes**
- Obtener todos los teléfonos con su marca:

```sql
SELECT p.nombre AS telefono, p.precio, m.nombre AS marca
FROM phone p
JOIN marca m ON p.marca_id = m.id;
```

- Contar cuántos teléfonos tiene cada marca:

```sql
SELECT m.nombre AS marca, COUNT(p.id) AS total_telefonos
FROM marca m
LEFT JOIN phone p ON m.id = p.marca_id
GROUP BY m.nombre;
```

Este diseño es escalable y te permite gestionar fácilmente las relaciones entre marcas y teléfonos. Si necesitas algún ajuste o explicación adicional, avísame.

#!/usr/bin/env node
/**
 * Script para generar structured data para cada página de curso
 * Genera snippets JSON-LD basados en los datos de cursos-data.js
 */

const fs = require('fs');
const path = require('path');

// Importar datos de cursos
const CURSOS_DATA = require('./cursos-data.js');

// Mapeo de categorías
const categoryMap = {
    'mantencion': 'Mantención y Producción',
    'computacion': 'Computación',
    'habilidades': 'Habilidades Blandas',
    'idiomas': 'Idiomas'
};

// Función para generar JSON-LD para un curso
function generateCourseStructuredData(course) {
    const categoryName = categoryMap[course.category] || course.category;
    const modalityText = course.modality === 'elearning' ? 'En línea' : 'Presencial';
    
    return {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "@id": "https://www.selitec.cl/#organization",
                "name": "Selitec Capacitación",
                "url": "https://www.selitec.cl",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://www.selitec.cl/assets/logo oficial.jpg"
                }
            },
            {
                "@type": "Course",
                "name": course.title,
                "description": course.desc,
                "provider": {
                    "@id": "https://www.selitec.cl/#organization"
                },
                "courseCode": `SELITEC-${course.id}`,
                "educationalLevel": "Profesional",
                "timeRequired": `PT${course.hours}H`,
                "inLanguage": "es-CL",
                "availableLanguage": "es",
                "hasCourseInstance": {
                    "@type": "CourseInstance",
                    "courseMode": course.modality === 'elearning' ? 'online' : 'onsite',
                    "courseWorkload": `PT${course.hours}H`,
                    "instructor": {
                        "@type": "Organization",
                        "@id": "https://www.selitec.cl/#organization"
                    }
                },
                "about": {
                    "@type": "Thing",
                    "name": categoryName
                },
                "offers": {
                    "@type": "Offer",
                    "category": "Paid",
                    "availability": "https://schema.org/InStock",
                    "priceCurrency": "CLP"
                }
            },
            {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": "Inicio",
                        "item": "https://www.selitec.cl/"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "Cursos",
                        "item": "https://www.selitec.cl/cursos/"
                    },
                    {
                        "@type": "ListItem",
                        "position": 3,
                        "name": course.shortTitle,
                        "item": `https://www.selitec.cl/curso/${course.slug}/`
                    }
                ]
            }
        ]
    };
}

// Función para insertar structured data en archivo HTML
function addStructuredDataToHTML(filePath, structuredData) {
    try {
        let html = fs.readFileSync(filePath, 'utf8');
        
        // Verificar si ya existe structured data
        if (html.includes('application/ld+json')) {
            console.log(`⚠️  ${path.basename(filePath)} ya tiene structured data, omitiendo...`);
            return false;
        }
        
        // Crear el script tag con structured data
        const scriptTag = `
    <!-- Structured Data: Course + Organization + Breadcrumbs -->
    <script type="application/ld+json">
    ${JSON.stringify(structuredData, null, 2)}
    </script>
</head>`;
        
        // Reemplazar el cierre de </head>
        html = html.replace('</head>', scriptTag);
        
        // Escribir el archivo actualizado
        fs.writeFileSync(filePath, html, 'utf8');
        console.log(`✅ Structured data agregada a: ${path.basename(filePath)}`);
        return true;
        
    } catch (error) {
        console.error(`❌ Error procesando ${filePath}:`, error.message);
        return false;
    }
}

// Procesar todos los cursos
function main() {
    console.log('🚀 Iniciando generación de structured data para cursos...\n');
    
    let successCount = 0;
    let skipCount = 0;
    let errorCount = 0;
    
    CURSOS_DATA.forEach(course => {
        const filePath = path.join(__dirname, 'curso', course.slug, 'index.html');
        
        if (!fs.existsSync(filePath)) {
            console.log(`⚠️  Archivo no encontrado: ${filePath}`);
            errorCount++;
            return;
        }
        
        const structuredData = generateCourseStructuredData(course);
        const result = addStructuredDataToHTML(filePath, structuredData);
        
        if (result === true) {
            successCount++;
        } else if (result === false) {
            skipCount++;
        } else {
            errorCount++;
        }
    });
    
    console.log('\n📊 Resumen:');
    console.log(`   ✅ Agregadas: ${successCount}`);
    console.log(`   ⏭️  Omitidas: ${skipCount}`);
    console.log(`   ❌ Errores: ${errorCount}`);
    console.log(`   📝 Total: ${CURSOS_DATA.length}`);
}

// Ejecutar si es llamado directamente
if (require.main === module) {
    main();
}

module.exports = { generateCourseStructuredData };

// Database de todos los cursos SELITEC
const CURSOS_DATA = [
    // === MANTENCIÓN Y PRODUCCIÓN ===
    {
        id: 1,
        slug: "operacion-calderas-termofluido",
        category: "mantencion",
        modality: "presencial",
        title: "Operación de Calderas de Termo fluido (40 horas)",
        shortTitle: "Operación de Calderas de Termo fluido",
        hours: 40,
        desc: "Operación de Calderas de Termo fluido (40 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Temario-Operación-de-Calderas-de-Fluidos-Termicos.pdf"
    },
    {
        id: 2,
        slug: "metrologia-ajustes-tolerancias",
        category: "mantencion",
        modality: "presencial",
        title: "Metrología, Ajustes y Tolerancias (35 horas)",
        shortTitle: "Metrología, Ajustes y Tolerancias",
        hours: 35,
        desc: "Metrología, Ajustes y Tolerancias (35 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Metrología-Ajustes-y-Tolerancias.pdf"
    },
    {
        id: 3,
        slug: "manejo-operacion-autoclave",
        category: "mantencion",
        modality: "presencial",
        title: "Manejo y operación de Autoclave (35 horas)",
        shortTitle: "Manejo y operación de Autoclave",
        hours: 35,
        desc: "Manejo y operación de Autoclave (35 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Temario-Operación-de-Autoclaves.pdf"
    },
    {
        id: 4,
        slug: "tecnica-maniobra-rigger",
        category: "mantencion",
        modality: "presencial",
        title: "Técnica y Maniobra Rigger",
        shortTitle: "Técnica y Maniobra Rigger",
        hours: 40,
        desc: "El programa de oficio \"Rigger\" pretende entregar a los alumnos las herramientas necesarias para estibar, reconocer riesgos y desarrollar la función de rigger de forma segura",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Técnicas-y-Maniobras-Rigger.pdf"
    },
    {
        id: 5,
        slug: "prevencion-riesgos-operacionales",
        category: "mantencion",
        modality: "presencial",
        title: "Técnicas de prevención de riesgos operacionales (20 Horas)",
        shortTitle: "Prevención de riesgos operacionales",
        hours: 20,
        desc: "Técnicas de prevención de riesgos operacionales (20 Horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Técnicas-de-Prevención-de-Riesgos-Operacionales-0225.pdf"
    },
    {
        id: 6,
        slug: "gasfiteria-instalaciones-sanitarias",
        category: "mantencion",
        modality: "presencial",
        title: "Técnicas de gasfitería e instalaciones sanitarias (40 horas)",
        shortTitle: "Gasfitería e instalaciones sanitarias",
        hours: 40,
        desc: "Técnicas de gasfitería e instalaciones sanitarias (40 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Técnicas-de-Gasfisteria-e-Instalaciones-Sanotarias-0222.pdf"
    },
    {
        id: 7,
        slug: "operacion-transpaleta-electrica",
        category: "mantencion",
        modality: "presencial",
        title: "Operación y Mantención Transpaleta Eléctrica (24 horas)",
        shortTitle: "Transpaleta Eléctrica",
        hours: 24,
        desc: "Operación y Mantención Transpaleta Eléctrica (24 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Operación-y-Mantención-de-Transpaleta-Eléctrica-24-Horas.pdf"
    },
    {
        id: 8,
        slug: "mecanica-mantencion-equipos-industriales",
        category: "mantencion",
        modality: "presencial",
        title: "Mecánica, mantención máquinas y equipos industriales (24 horas)",
        shortTitle: "Mantención equipos industriales",
        hours: 24,
        desc: "Mecánica, mantención máquinas y equipos industriales (mantención básica) (24 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Mecánica-Mantención-Máquinas-y-Equipos-Industriales-0289.pdf"
    },
    {
        id: 9,
        slug: "interpretacion-planos-electricos",
        category: "mantencion",
        modality: "presencial",
        title: "Interpretación de planos eléctricos (43 horas)",
        shortTitle: "Interpretación de planos eléctricos",
        hours: 43,
        desc: "Interpretación de planos eléctricos (43 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Interpretación-Planos-Electricos.pdf"
    },
    {
        id: 10,
        slug: "instalacion-reparaciones-electricas",
        category: "mantencion",
        modality: "presencial",
        title: "Instalación y reparaciones eléctricas",
        shortTitle: "Instalación y reparaciones eléctricas",
        hours: 40,
        desc: "Instalación y reparaciones eléctricas",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Instalaciones-y-Reparaciones-Eléctricas.pdf"
    },
    {
        id: 11,
        slug: "neumatica-aplicada",
        category: "mantencion",
        modality: "presencial",
        title: "Neumática Aplicada (50 Horas)",
        shortTitle: "Neumática Aplicada",
        hours: 50,
        desc: "Neumática Aplicada (50 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Neumática-Aplicada-0156-02.pdf"
    },
    {
        id: 12,
        slug: "interpretacion-planos-mecanicos",
        category: "mantencion",
        modality: "presencial",
        title: "Interpretación de planos mecánicos (43 horas)",
        shortTitle: "Interpretación de planos mecánicos",
        hours: 43,
        desc: "Interpretación de planos mecánicos (43 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Interpretación-de-Planos-Mécanicos-02.pdf"
    },
    {
        id: 13,
        slug: "operador-caldera-completo",
        category: "mantencion",
        modality: "presencial",
        title: "Operador Caldera de Agua Caliente, Calefacción, Termo Fluido, Vapor y Autoclave (35 horas)",
        shortTitle: "Operador Caldera Completo",
        hours: 35,
        desc: "Operador Caldera de Agua Caliente, Calefacción, Termo Fluido, Vapor y Autoclave (35 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Temario-Calderas-y-Autoclaves-1.pdf"
    },
    {
        id: 14,
        slug: "operacion-gruas-horquillas",
        category: "mantencion",
        modality: "presencial",
        title: "Operación y Mantención de Grúas Horquillas (35 Horas)",
        shortTitle: "Grúas Horquillas",
        hours: 35,
        desc: "El programa de oficio \"Operación y Mantención de Grúas Horquillas\" pretende entregar a los alumnos las herramientas necesarias para conocer, operar y mantener una grúa horquilla de forma segura",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Operación-y-Mantención-de-Grúas-Horquillas-2017-1.pdf"
    },
    {
        id: 15,
        slug: "metrologia-mecanica-industrial",
        category: "mantencion",
        modality: "presencial",
        title: "Metrología Aplicada a la Mecánica Industrial (35 horas)",
        shortTitle: "Metrología Mecánica Industrial",
        hours: 35,
        desc: "Metrología Aplicada a la Mecánica Industrial (35 horas)",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Metrología-Ajustes-y-Tolerancias.pdf"
    },
    {
        id: 16,
        slug: "administracion-bodegas",
        category: "mantencion",
        modality: "presencial",
        title: "Administración de Bodegas (40 Horas)",
        shortTitle: "Administración de Bodegas",
        hours: 40,
        desc: "El programa de oficio \"Administración de Bodegas\" pretende entregar las mejores técnicas disponibles que permita a los participantes comprender, enfrentar y resolver eficientemente los problemas que se encuentran dentro de una Bodega",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Administracion-de-Bodegas-1.pdf"
    },
    {
        id: 17,
        slug: "administracion-bodegas-2",
        category: "mantencion",
        modality: "presencial",
        title: "Administración de Bodegas II (46 Horas)",
        shortTitle: "Administración de Bodegas II",
        hours: 46,
        desc: "El programa de oficio \"Administración de Bodegas II\" pretende entregar las mejores técnicas disponibles que permita a los participantes comprender, enfrentar y resolver eficientemente los problemas que se encuentran dentro de una Bodega",
        image: "../assets/temario_mantencionYproduccion.jpg",
        pdf: "../assets/temarios/mantencion_y_produccion/Administración-de-Bodegas-II.pdf"
    },

    // === COMPUTACIÓN ===
    {
        id: 18,
        slug: "excel-basico",
        category: "computacion",
        modality: "elearning",
        title: "Excel Básico (35 horas)",
        shortTitle: "Excel Básico",
        hours: 35,
        desc: "El alumno al término del curso será capaz de conocer y utilizar los elementos de la pantalla de trabajo, manejar las barras de herramientas y menús, ejecutar procedimientos para selección de celdas, insertar datos, crear nuevas hojas de cálculo",
        image: "../assets/temario_computacion.jpg",
        pdf: "../assets/temarios/computacion/EXCEL-BASICO-35-HORAS.pdf"
    },
    {
        id: 19,
        slug: "excel-avanzado",
        category: "computacion",
        modality: "elearning",
        title: "Excel Avanzado (35 horas)",
        shortTitle: "Excel Avanzado",
        hours: 35,
        desc: "Al Término del curso el alumno sabrá manejar las funciones lógicas. Fecha y hora, administración, financieros, estadísticas, realizará las funciones correspondientes a Macros, barras de herramientas, formularios y botones de control",
        image: "../assets/temario_computacion.jpg",
        pdf: "../assets/temarios/computacion/EXCEL-AVANZADO-35-HORAS02.pdf"
    },

    // === HABILIDADES BLANDAS ===
    {
        id: 20,
        slug: "tecnicas-desarrollo-equipos-trabajo",
        category: "habilidades",
        modality: "presencial",
        title: "Técnicas Laborales para el Desarrollo y Evolución de Equipos de Trabajo (22 Horas)",
        shortTitle: "Desarrollo de Equipos de Trabajo",
        hours: 22,
        desc: "Técnicas Laborales para el Desarrollo y Evolución de Equipos de Trabajo",
        image: "../assets/temario_habilidadesblandas.jpg",
        pdf: "../assets/temarios/habilidades_blandas/Técnicas-Laborales-para-el-Desarrollo-y-Evaluacion-del-Trabajo-en-Equipo.pdf"
    },
    {
        id: 21,
        slug: "administracion-tiempo-control-tareas",
        category: "habilidades",
        modality: "presencial",
        title: "Administración del tiempo y control de tareas (16 horas)",
        shortTitle: "Administración del tiempo",
        hours: 16,
        desc: "Administración del tiempo y control de tareas (16 horas)",
        image: "../assets/temario_habilidadesblandas.jpg",
        pdf: "../assets/temarios/habilidades_blandas/Administración-del-tiempo-y-control-de-tareas-ok.pdf"
    },

    // === IDIOMAS ===
    {
        id: 22,
        slug: "espanol-basico-integracion-laboral",
        category: "idiomas",
        modality: "presencial",
        title: "Español Básico para la Integración Laboral (40 Horas)",
        shortTitle: "Español Básico para Integración Laboral",
        hours: 40,
        desc: "Español Básico para la Integración Laboral (40 Horas)",
        image: "../assets/temario_idiomas.jpg",
        pdf: "../assets/temarios/idiomas/Español-Básico-para-la-Integración-Laboral.pdf"
    }
];

// Exportar para uso en otros archivos
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CURSOS_DATA;
}

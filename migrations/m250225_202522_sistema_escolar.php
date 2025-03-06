<?php

use yii\db\Migration;

class m240225_000000_create_all_tables extends Migration
{
    public function safeUp()
    {
        // Tabla Institucion
        $this->createTable('Institucion', [
            'id_institucion' => $this->primaryKey(),
            'nombre' => $this->string(80)->notNull(),
        ]);

        // Tabla Semestre
        $this->createTable('Semestre', [
            'id_semestre' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull(),
        ]);

        // Tabla Grado
        $this->createTable('Grado', [
            'id_grado' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull(),
        ]);

        // Tabla Grupos
        $this->createTable('Grupos', [
            'id_grupo' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull(),
        ]);

        // Tabla Cualidades
        $this->createTable('Cualidades', [
            'id_cualidades' => $this->primaryKey(),
            'cualidades' => $this->text(),
        ]);

        // Tabla Carrera
        $this->createTable('Carrera', [
            'id_carrera' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull(),
            'id_cualidades' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_carrera_cualidades', 'Carrera', 'id_cualidades', 'Cualidades', 'id_cualidades', 'CASCADE', 'CASCADE');

        // Tabla Turnos
        $this->createTable('Turnos', [
            'id_turno' => $this->primaryKey(),
            'nombre' => $this->string(50)->notNull(),
        ]);

        // Tabla Ciclo_escolar
        $this->createTable('Ciclo_escolar', [
            'id_ciclo' => $this->primaryKey(),
            'ciclo' => $this->string(100)->notNull(),
        ]);

        // Tabla Fondo_CBT
        $this->createTable('Fondo_CBT', [
            'id_fondo' => $this->primaryKey(),
            'fondo_imagen' => $this->string(100)->notNull(),
            'status' => $this->enum(['VIGENTE', 'NO VIGENTE'])->notNull(),
        ]);

        // Tabla Alumnos
        $this->createTable('Alumnos', [
            'id_alumno' => $this->primaryKey(),
            'correo' => $this->string(100)->notNull()->unique(),
            'curp' => $this->string(50)->notNull()->unique(),
            'nombre' => $this->string(80)->notNull(),
            'apellido_paterno' => $this->string(80)->notNull(),
            'apellido_materno' => $this->string(80)->notNull(),
            'id_semestreactual' => $this->integer()->notNull(),
            'id_institucion' => $this->integer()->notNull(),
            'nss' => $this->string(50)->notNull()->unique(),
            'fecha_nacimiento' => $this->date()->notNull(),
            'sexo' => $this->enum(['F', 'M'])->notNull(),
            'id_grado' => $this->integer()->notNull(),
            'id_grupo' => $this->integer()->notNull(),
            'id_carrera' => $this->integer()->notNull(),
            'id_turno' => $this->integer()->notNull(),
            'telefono_uno' => $this->string(15),
            'telefono_dos' => $this->string(15),
            'calle' => $this->string(50),
            'numero' => $this->string(10),
            'colonia' => $this->string(100),
            'codigo_postal' => $this->string(10),
            'municipio' => $this->string(80),
            'id_ciclo' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_alumnos_semestre', 'Alumnos', 'id_semestreactual', 'Semestre', 'id_semestre', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_alumnos_institucion', 'Alumnos', 'id_institucion', 'Institucion', 'id_institucion', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_alumnos_grado', 'Alumnos', 'id_grado', 'Grado', 'id_grado', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_alumnos_grupo', 'Alumnos', 'id_grupo', 'Grupos', 'id_grupo', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_alumnos_carrera', 'Alumnos', 'id_carrera', 'Carrera', 'id_carrera', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_alumnos_turno', 'Alumnos', 'id_turno', 'Turnos', 'id_turno', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_alumnos_ciclo', 'Alumnos', 'id_ciclo', 'Ciclo_escolar', 'id_ciclo', 'CASCADE', 'CASCADE');

        // Tabla Empresa
        $this->createTable('Empresa', [
            'id_empresa' => $this->primaryKey(),
            'nombre' => $this->string(100)->notNull(),
            'perfil_profesional' => $this->string(100)->notNull(),
            'cargo' => $this->string(80)->notNull(),
            'nombre_lugar' => $this->string(150)->notNull(),
            'calle' => $this->string(100)->notNull(),
            'colonia' => $this->string(100)->notNull(),
            'numero' => $this->string(10)->notNull(),
            'codigo_postal' => $this->string(15)->notNull(),
            'municipio' => $this->string(80)->notNull(),
            'telefono_uno' => $this->string(15)->notNull(),
            'telefono_dos' => $this->string(15)->notNull(),
            'correo' => $this->string(100)->notNull(),
            'logo' => $this->string(100),
        ]);

        // Tabla Cartas_alumno
        $this->createTable('Cartas_alumno', [
            'id_cartasalumno' => $this->primaryKey(),
            'id_alumno' => $this->integer()->notNull(),
            'hoja_datos' => $this->string(100),
            'carta_presentacion' => $this->string(100),
            'carta_aceptacion' => $this->string(100),
            'carta_termino' => $this->string(100),
        ]);
        $this->addForeignKey('fk_cartasalumno_alumno', 'Cartas_alumno', 'id_alumno', 'Alumnos', 'id_alumno', 'CASCADE', 'CASCADE');

        // Tabla Hoja_Datos
        $this->createTable('Hoja_Datos', [
            'id_hojadatos' => $this->primaryKey()->append('AUTO_INCREMENT'),
            'id_alumno' => $this->integer()->notNull(),
            'id_empresa' => $this->integer()->notNull(),
            'status' => $this->enum(['ACEPTADO', 'EN REVISION', 'RECHAZADO'])->notNull(),
            'id_semestre' => $this->integer()->notNull(),
            'id_ciclo' => $this->integer()->notNull(),
            'id_formato' => $this->integer()->notNull(),
            'fecha_emision' => $this->date()->notNull(),
            'fecha_aceptacion' => $this->date()->notNull(),
        ]);
        $this->addForeignKey('fk_hojadatos_alumno', 'Hoja_Datos', 'id_alumno', 'Alumnos', 'id_alumno', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_hojadatos_empresa', 'Hoja_Datos', 'id_empresa', 'Empresa', 'id_empresa', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_hojadatos_semestre', 'Hoja_Datos', 'id_semestre', 'Semestre', 'id_semestre', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_hojadatos_ciclo', 'Hoja_Datos', 'id_ciclo', 'Ciclo_escolar', 'id_ciclo', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_hojadatos_formato', 'Hoja_Datos', 'id_formato', 'Fondo_CBT', 'id_fondo', 'CASCADE', 'CASCADE');

        // Tabla Carta_presentacion
        $this->createTable('Carta_presentacion', [
            'id_cartapresentacion' => $this->primaryKey(),
            'id_formato' => $this->integer()->notNull(),
            'id_alumno' => $this->integer()->notNull(),
            'status' => $this->enum(['ACEPTADO', 'EN REVISION', 'RECHAZADO'])->notNull(),
            'id_semestre' => $this->integer()->notNull(),
            'id_ciclo' => $this->integer()->notNull(),
            'fecha_emision' => $this->date()->notNull(),
            'fecha_aceptacion' => $this->date()->notNull(),
        ]);
        $this->addForeignKey('fk_cartapresentacion_alumno', 'Carta_presentacion', 'id_alumno', 'Alumnos', 'id_alumno', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartapresentacion_semestre', 'Carta_presentacion', 'id_semestre', 'Semestre', 'id_semestre', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartapresentacion_ciclo', 'Carta_presentacion', 'id_ciclo', 'Ciclo_escolar', 'id_ciclo', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartapresentacion_formato', 'Carta_presentacion', 'id_formato', 'Fondo_CBT', 'id_fondo', 'CASCADE', 'CASCADE');

        // Tabla Carta_aceptacion
        $this->createTable('Carta_aceptacion', [
            'id_cartaaceptacion' => $this->primaryKey(),
            'id_alumno' => $this->integer()->notNull(),
            'status' => $this->enum(['ACEPTADO', 'EN REVISION', 'RECHAZADO'])->notNull(),
            'id_semestre' => $this->integer()->notNull(),
            'id_ciclo' => $this->integer()->notNull(),
            'area' => $this->string(100)->notNull(),
            'fecha_inicio' => $this->date()->notNull(),
            'fecha_termino' => $this->date()->notNull(),
            'horario' => $this->string(200)->notNull(),
            'fecha_emision' => $this->date()->notNull(),
            'fecha_aceptacion' => $this->date()->notNull(),
        ]);
        $this->addForeignKey('fk_cartaaceptacion_alumno', 'Carta_aceptacion', 'id_alumno', 'Alumnos', 'id_alumno', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartaaceptacion_semestre', 'Carta_aceptacion', 'id_semestre', 'Semestre', 'id_semestre', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartaaceptacion_ciclo', 'Carta_aceptacion', 'id_ciclo', 'Ciclo_escolar', 'id_ciclo', 'CASCADE', 'CASCADE');

        // Tabla Carta_termino
        $this->createTable('Carta_termino', [
            'id_cartatermino' => $this->primaryKey(),
            'id_alumno' => $this->integer()->notNull(),
            'status' => $this->enum(['ACEPTADO', 'EN REVISION', 'RECHAZADO'])->notNull(),
            'id_semestre' => $this->integer()->notNull(),
            'id_ciclo' => $this->integer()->notNull(),
            'fecha_emision' => $this->date()->notNull(),
            'fecha_aceptacion' => $this->date()->notNull(),
        ]);
        $this->addForeignKey('fk_cartatermino_alumno', 'Carta_termino', 'id_alumno', 'Alumnos', 'id_alumno', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartatermino_semestre', 'Carta_termino', 'id_semestre', 'Semestre', 'id_semestre', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_cartatermino_ciclo', 'Carta_termino', 'id_ciclo', 'Ciclo_escolar', 'id_ciclo', 'CASCADE', 'CASCADE');
    
        $this->insert('Institucion', [
            'nombre' => 'Unidad Académica Profesional Tianguistenco'
        ]);
        $this->insert('Institucion', [
            'nombre' => 'CBT No. 2, Metepec'
        ]);
        $this->insert('Institucion', [
            'nombre' => 'CBT No. 3, Metepec'
        ]);

        $this->insert('Semestre', [
            'nombre' => 'Cuarto'
        ]);
        $this->insert('Semestre', [
            'nombre' => 'Quinto'
        ]);
        $this->insert('Semestre', [
            'nombre' => 'Tercer'
        ]);

        $this->insert('Grado', [
            'nombre' => 'PRIMERO'
        ]);
        $this->insert('Grado', [
            'nombre' => 'SEGUNDO'
        ]);
        $this->insert('Grado', [
            'nombre' => 'TERCERO'
        ]);

        $this->insert('Grupos', [
            'nombre' => 'UNO'
        ]);
        $this->insert('Grupos', [
            'nombre' => 'DOS'
        ]);
        $this->insert('Grupos', [
            'nombre' => 'TRES'
        ]);

        $this->insert('Carrera', [
            'nombre' => 'Programación'
        ]);
        $this->insert('Carrera', [
            'nombre' => 'Diseño'
        ]);
        $this->insert('Carrera', [
            'nombre' => 'Computación'
        ]);

        $this->insert('Cualidades', [
            'cualidad' => 'Conocimiento en computación y java'
        ]);
        $this->insert('Cualidades', [
            'cualidad' => 'Conocimiento en dibujo y diseño'
        ]);
        $this->insert('Cualidades', [
            'cualidad' => 'Conocimiento de computación'
        ]);

        $this->insert('Turnos', [
            'nombre' => 'Matutino'
        ]);
        $this->insert('Turnos', [
            'nombre' => 'Vespertino'
        ]);

        $this->insert('Ciclo_escolar', [
            'ciclo' => '2024-2025'
        ]);



    }

    public function safeDown()
    {
        // Eliminar tablas en orden inverso
        $this->dropTable('Carta_termino');
        $this->dropTable('Carta_aceptacion');
        $this->dropTable('Carta_presentacion');
        $this->dropTable('Hoja_Datos');
        $this->dropTable('Cartas_alumno');
        $this->dropTable('Empresa');
        $this->dropTable('Alumnos');
        $this->dropTable('Fondo_CBT');
        $this->dropTable('Ciclo_escolar');
        $this->dropTable('Turnos');
        $this->dropTable('Carrera');
        $this->dropTable('Cualidades');
        $this->dropTable('Grupos');
        $this->dropTable('Grado');
        $this->dropTable('Semestre');
        $this->dropTable('Institucion');
    }
}
<?php

namespace Laurent\SchoolBundle\Migrations\pdo_sqlsrv;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/09/07 12:04:18
 */
class Version20140907000416 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE laurent_school_plan_matiere (
                id INT IDENTITY NOT NULL, 
                matiere_id INT, 
                referentiel_id INT, 
                name NVARCHAR(255) NOT NULL, 
                refProgramme NVARCHAR(255) NOT NULL, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_C1FE0911F46CD258 ON laurent_school_plan_matiere (matiere_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_C1FE0911805DB139 ON laurent_school_plan_matiere (referentiel_id)
        ");
        $this->addSql("
            CREATE TABLE laurent_school_planmatiere_user (
                planmatiere_id INT NOT NULL, 
                user_id INT NOT NULL, 
                PRIMARY KEY (planmatiere_id, user_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_622F13F492E8E50 ON laurent_school_planmatiere_user (planmatiere_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_622F13F4A76ED395 ON laurent_school_planmatiere_user (user_id)
        ");
        $this->addSql("
            CREATE TABLE laurent_school_point_matiere (
                id INT IDENTITY NOT NULL, 
                name NVARCHAR(255) NOT NULL, 
                nbPeriode INT, 
                ordre INT, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE TABLE laurent_school_pointmatiere_chapitreplanmatiere (
                pointmatiere_id INT NOT NULL, 
                chapitreplanmatiere_id INT NOT NULL, 
                PRIMARY KEY (
                    pointmatiere_id, chapitreplanmatiere_id
                )
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_F90F73EC1ADE166B ON laurent_school_pointmatiere_chapitreplanmatiere (pointmatiere_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_F90F73EC5E680512 ON laurent_school_pointmatiere_chapitreplanmatiere (chapitreplanmatiere_id)
        ");
        $this->addSql("
            CREATE TABLE laurent_school_pointmatiere_competence (
                pointmatiere_id INT NOT NULL, 
                competence_id INT NOT NULL, 
                PRIMARY KEY (pointmatiere_id, competence_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_1C33BE691ADE166B ON laurent_school_pointmatiere_competence (pointmatiere_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_1C33BE6915761DAB ON laurent_school_pointmatiere_competence (competence_id)
        ");
        $this->addSql("
            CREATE TABLE laurent_school_chapitre_plan_matiere (
                id INT IDENTITY NOT NULL, 
                name NVARCHAR(255) NOT NULL, 
                nbPeriode INT, 
                ordre INT, 
                moment INT, 
                annee INT, 
                planMatiere_id INT, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_3D3A30C746738D80 ON laurent_school_chapitre_plan_matiere (planMatiere_id)
        ");
        $this->addSql("
            CREATE TABLE laurent_school_matiere (
                id INT IDENTITY NOT NULL, 
                name NVARCHAR(255) NOT NULL, 
                degre INT, 
                nbPeriode INT, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE TABLE laurent_school_classe (
                id INT IDENTITY NOT NULL, 
                code NVARCHAR(255) NOT NULL, 
                name NVARCHAR(255) NOT NULL, 
                degre INT, 
                annee INT, 
                Workspace_id INT, 
                Group_id INT, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_CBC542A19AE5D1E7 ON laurent_school_classe (Workspace_id) 
            WHERE Workspace_id IS NOT NULL
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_CBC542A1722BB11 ON laurent_school_classe (Group_id) 
            WHERE Group_id IS NOT NULL
        ");
        $this->addSql("
            CREATE TABLE laurent_school_classe_user (
                classe_id INT NOT NULL, 
                user_id INT NOT NULL, 
                PRIMARY KEY (classe_id, user_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_1386DAEC8F5EA509 ON laurent_school_classe_user (classe_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_1386DAECA76ED395 ON laurent_school_classe_user (user_id)
        ");
        $this->addSql("
            ALTER TABLE laurent_school_plan_matiere 
            ADD CONSTRAINT FK_C1FE0911F46CD258 FOREIGN KEY (matiere_id) 
            REFERENCES laurent_school_matiere (id)
        ");
        $this->addSql("
            ALTER TABLE laurent_school_plan_matiere 
            ADD CONSTRAINT FK_C1FE0911805DB139 FOREIGN KEY (referentiel_id) 
            REFERENCES claro_competence (id)
        ");
        $this->addSql("
            ALTER TABLE laurent_school_planmatiere_user 
            ADD CONSTRAINT FK_622F13F492E8E50 FOREIGN KEY (planmatiere_id) 
            REFERENCES laurent_school_plan_matiere (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_planmatiere_user 
            ADD CONSTRAINT FK_622F13F4A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_chapitreplanmatiere 
            ADD CONSTRAINT FK_F90F73EC1ADE166B FOREIGN KEY (pointmatiere_id) 
            REFERENCES laurent_school_point_matiere (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_chapitreplanmatiere 
            ADD CONSTRAINT FK_F90F73EC5E680512 FOREIGN KEY (chapitreplanmatiere_id) 
            REFERENCES laurent_school_chapitre_plan_matiere (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_competence 
            ADD CONSTRAINT FK_1C33BE691ADE166B FOREIGN KEY (pointmatiere_id) 
            REFERENCES laurent_school_point_matiere (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_competence 
            ADD CONSTRAINT FK_1C33BE6915761DAB FOREIGN KEY (competence_id) 
            REFERENCES claro_competence (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_chapitre_plan_matiere 
            ADD CONSTRAINT FK_3D3A30C746738D80 FOREIGN KEY (planMatiere_id) 
            REFERENCES laurent_school_plan_matiere (id)
        ");
        $this->addSql("
            ALTER TABLE laurent_school_classe 
            ADD CONSTRAINT FK_CBC542A19AE5D1E7 FOREIGN KEY (Workspace_id) 
            REFERENCES claro_workspace (id)
        ");
        $this->addSql("
            ALTER TABLE laurent_school_classe 
            ADD CONSTRAINT FK_CBC542A1722BB11 FOREIGN KEY (Group_id) 
            REFERENCES claro_group (id)
        ");
        $this->addSql("
            ALTER TABLE laurent_school_classe_user 
            ADD CONSTRAINT FK_1386DAEC8F5EA509 FOREIGN KEY (classe_id) 
            REFERENCES laurent_school_classe (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE laurent_school_classe_user 
            ADD CONSTRAINT FK_1386DAECA76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE laurent_school_planmatiere_user 
            DROP CONSTRAINT FK_622F13F492E8E50
        ");
        $this->addSql("
            ALTER TABLE laurent_school_chapitre_plan_matiere 
            DROP CONSTRAINT FK_3D3A30C746738D80
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_chapitreplanmatiere 
            DROP CONSTRAINT FK_F90F73EC1ADE166B
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_competence 
            DROP CONSTRAINT FK_1C33BE691ADE166B
        ");
        $this->addSql("
            ALTER TABLE laurent_school_pointmatiere_chapitreplanmatiere 
            DROP CONSTRAINT FK_F90F73EC5E680512
        ");
        $this->addSql("
            ALTER TABLE laurent_school_plan_matiere 
            DROP CONSTRAINT FK_C1FE0911F46CD258
        ");
        $this->addSql("
            ALTER TABLE laurent_school_classe_user 
            DROP CONSTRAINT FK_1386DAEC8F5EA509
        ");
        $this->addSql("
            DROP TABLE laurent_school_plan_matiere
        ");
        $this->addSql("
            DROP TABLE laurent_school_planmatiere_user
        ");
        $this->addSql("
            DROP TABLE laurent_school_point_matiere
        ");
        $this->addSql("
            DROP TABLE laurent_school_pointmatiere_chapitreplanmatiere
        ");
        $this->addSql("
            DROP TABLE laurent_school_pointmatiere_competence
        ");
        $this->addSql("
            DROP TABLE laurent_school_chapitre_plan_matiere
        ");
        $this->addSql("
            DROP TABLE laurent_school_matiere
        ");
        $this->addSql("
            DROP TABLE laurent_school_classe
        ");
        $this->addSql("
            DROP TABLE laurent_school_classe_user
        ");
    }
}
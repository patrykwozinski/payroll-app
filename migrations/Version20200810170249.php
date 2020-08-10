<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810170249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id UUID NOT NULL, name VARCHAR(255) NOT NULL, bonus_type VARCHAR(255) NOT NULL, bonus_value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD1DE18A5E237E06 ON department (name)');
        $this->addSql('COMMENT ON COLUMN department.id IS \'(DC2Type:department_id)\'');
        $this->addSql('CREATE TABLE payroll (id UUID NOT NULL, generated_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN payroll.id IS \'(DC2Type:payroll_id)\'');
        $this->addSql('CREATE TABLE payroll_payroll_record (payroll_id UUID NOT NULL, payroll_record_id UUID NOT NULL, PRIMARY KEY(payroll_id, payroll_record_id))');
        $this->addSql('CREATE INDEX IDX_F3F04582DBA340EA ON payroll_payroll_record (payroll_id)');
        $this->addSql('CREATE INDEX IDX_F3F04582FCA30F89 ON payroll_payroll_record (payroll_record_id)');
        $this->addSql('COMMENT ON COLUMN payroll_payroll_record.payroll_id IS \'(DC2Type:payroll_id)\'');
        $this->addSql('COMMENT ON COLUMN payroll_payroll_record.payroll_record_id IS \'(DC2Type:payroll_record_id)\'');
        $this->addSql('CREATE TABLE payroll_record (id UUID NOT NULL, payroll_id UUID DEFAULT NULL, department_id UUID DEFAULT NULL, worker_id UUID NOT NULL, salary DOUBLE PRECISION NOT NULL, salary_bonus DOUBLE PRECISION NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1588A6DBDBA340EA ON payroll_record (payroll_id)');
        $this->addSql('CREATE INDEX IDX_1588A6DBAE80F5DF ON payroll_record (department_id)');
        $this->addSql('COMMENT ON COLUMN payroll_record.id IS \'(DC2Type:payroll_record_id)\'');
        $this->addSql('COMMENT ON COLUMN payroll_record.payroll_id IS \'(DC2Type:payroll_id)\'');
        $this->addSql('COMMENT ON COLUMN payroll_record.department_id IS \'(DC2Type:department_id)\'');
        $this->addSql('COMMENT ON COLUMN payroll_record.worker_id IS \'(DC2Type:worker_id)\'');
        $this->addSql('CREATE TABLE worker (id UUID NOT NULL, department_id UUID DEFAULT NULL, salary DOUBLE PRECISION NOT NULL, hired_at DATE NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FB2BF62AE80F5DF ON worker (department_id)');
        $this->addSql('COMMENT ON COLUMN worker.id IS \'(DC2Type:worker_id)\'');
        $this->addSql('COMMENT ON COLUMN worker.department_id IS \'(DC2Type:department_id)\'');
        $this->addSql('ALTER TABLE payroll_payroll_record ADD CONSTRAINT FK_F3F04582DBA340EA FOREIGN KEY (payroll_id) REFERENCES payroll (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payroll_payroll_record ADD CONSTRAINT FK_F3F04582FCA30F89 FOREIGN KEY (payroll_record_id) REFERENCES payroll_record (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payroll_record ADD CONSTRAINT FK_1588A6DBDBA340EA FOREIGN KEY (payroll_id) REFERENCES payroll (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payroll_record ADD CONSTRAINT FK_1588A6DBAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF62AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE payroll_record DROP CONSTRAINT FK_1588A6DBAE80F5DF');
        $this->addSql('ALTER TABLE worker DROP CONSTRAINT FK_9FB2BF62AE80F5DF');
        $this->addSql('ALTER TABLE payroll_payroll_record DROP CONSTRAINT FK_F3F04582DBA340EA');
        $this->addSql('ALTER TABLE payroll_record DROP CONSTRAINT FK_1588A6DBDBA340EA');
        $this->addSql('ALTER TABLE payroll_payroll_record DROP CONSTRAINT FK_F3F04582FCA30F89');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE payroll');
        $this->addSql('DROP TABLE payroll_payroll_record');
        $this->addSql('DROP TABLE payroll_record');
        $this->addSql('DROP TABLE worker');
    }
}

<?php
namespace Database\Seeders;

use App\Models\ComPermission;
use App\Models\ComResponsibleSection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'          => 'Admin User',
            'email'         => 'admin@suswebapp.com',
            'password'      => Hash::make('Admin@1234'),
            'userType'      => '1',
            'assigneeLevel' => '1',
        ]);

        User::factory()->create([
            'name'          => 'Super Admin',
            'email'         => 'supperadmin@suswebapp.com',
            'password'      => Hash::make('Supperadmin@1234'),
            'userType'      => '1',
            'assigneeLevel' => '1',

        ]);

        ComPermission::factory()->create([
            'id'               => 1,
            'userType'         => 'Super Admin',
            'description'      => 'Administrator Role with full permissions',
            'permissionObject' => ([
                "INSIGHT_VIEW"                                                     => true,
                "ADMIN_USERS_EDIT"                                                 => true,
                "ADMIN_USERS_VIEW"                                                 => true,
                "RAG_REGISTER_EDIT"                                                => true,
                "RAG_REGISTER_VIEW"                                                => true,
                "ADMIN_USERS_DELETE"                                               => true,
                "RAG_DASHBOARD_EDIT"                                               => true,
                "RAG_DASHBOARD_VIEW"                                               => true,
                "RAG_REGISTER_CREATE"                                              => true,
                "RAG_REGISTER_DELETE"                                              => true,
                "RAG_DASHBOARD_CREATE"                                             => true,
                "RAG_DASHBOARD_DELETE"                                             => true,
                "ADMIN_ACCESS_MNG_EDIT"                                            => true,
                "ADMIN_ACCESS_MNG_VIEW"                                            => true,
                "DOCUMENT_REGISTER_EDIT"                                           => true,
                "DOCUMENT_REGISTER_VIEW"                                           => true,
                "ADMIN_ACCESS_MNG_CREATE"                                          => true,
                "ADMIN_ACCESS_MNG_DELETE"                                          => true,
                "ATTRITION_REGISTER_EDIT"                                          => true,
                "ATTRITION_REGISTER_VIEW"                                          => true,
                "GRIEVANCE_REGISTER_EDIT"                                          => true,
                "GRIEVANCE_REGISTER_VIEW"                                          => true,
                "RAG_ASSIGNED_TASKS_EDIT"                                          => true,
                "RAG_ASSIGNED_TASKS_VIEW"                                          => true,
                "DOCUMENT_REGISTER_CREATE"                                         => true,
                "DOCUMENT_REGISTER_DELETE"                                         => true,
                "ENGAGEMENT_REGISTER_EDIT"                                         => true,
                "ENGAGEMENT_REGISTER_VIEW"                                         => true,
                "GRIEVANCE_DASHBOARD_VIEW"                                         => true,
                "SATISFACTION_SURVEY_EDIT"                                         => true,
                "SATISFACTION_SURVEY_VIEW"                                         => true,
                "ATTRITION_REGISTER_CREATE"                                        => true,
                "ATTRITION_REGISTER_DELETE"                                        => true,
                "GRIEVANCE_REGISTER_CREATE"                                        => true,
                "GRIEVANCE_REGISTER_DELETE"                                        => true,
                "HAZARD_RISK_REGISTER_EDIT"                                        => true,
                "HAZARD_RISK_REGISTER_VIEW"                                        => true,
                "RAG_ASSIGNED_TASKS_CREATE"                                        => true,
                "RAG_ASSIGNED_TASKS_DELETE"                                        => true,
                "ENGAGEMENT_REGISTER_CREATE"                                       => true,
                "ENGAGEMENT_REGISTER_DELETE"                                       => true,
                "ENVIRONMENT_DASHBOARD_VIEW"                                       => true,
                "HAZARD_RISK_DASHBOARD_VIEW"                                       => true,
                "SATISFACTION_SURVEY_CREATE"                                       => true,
                "SATISFACTION_SURVEY_DELETE"                                       => true,
                "CHEMICAL_MNG_DASHBOARD_VIEW"                                      => true,
                "HAZARD_RISK_REGISTER_CREATE"                                      => true,
                "HAZARD_RISK_REGISTER_DELETE"                                      => true,
                "CHEMICAL_MNG_TRANSACTION_EDIT"                                    => true,
                "CHEMICAL_MNG_TRANSACTION_VIEW"                                    => true,
                "GRIEVANCE_ASSIGNED_TASKS_EDIT"                                    => true,
                "GRIEVANCE_ASSIGNED_TASKS_VIEW"                                    => true,
                "AUDIT_INSPECTION_CALENDAR_EDIT"                                   => true,
                "AUDIT_INSPECTION_CALENDAR_VIEW"                                   => true,
                "AUDIT_INSPECTION_DASHBOARD_EDIT"                                  => true,
                "AUDIT_INSPECTION_DASHBOARD_VIEW"                                  => true,
                "CHEMICAL_MNG_TRANSACTION_CREATE"                                  => true,
                "CHEMICAL_MNG_TRANSACTION_DELETE"                                  => true,
                "GRIEVANCE_ASSIGNED_TASKS_CREATE"                                  => true,
                "GRIEVANCE_ASSIGNED_TASKS_DELETE"                                  => true,
                "HAZARD_RISK_ASSIGNED_TASKS_EDIT"                                  => true,
                "HAZARD_RISK_ASSIGNED_TASKS_VIEW"                                  => true,
                "AUDIT_INSPECTION_CALENDAR_CREATE"                                 => true,
                "AUDIT_INSPECTION_CALENDAR_DELETE"                                 => true,
                "CHEMICAL_MNG_ASSIGNED_TASKS_EDIT"                                 => true,
                "CHEMICAL_MNG_ASSIGNED_TASKS_VIEW"                                 => true,
                "INCIDENT_ACCIDENT_DASHBOARD_VIEW"                                 => true,
                "AUDIT_INSPECTION_DASHBOARD_CREATE"                                => true,
                "AUDIT_INSPECTION_DASHBOARD_DELETE"                                => true,
                "HAZARD_RISK_ASSIGNED_TASKS_CREATE"                                => true,
                "HAZARD_RISK_ASSIGNED_TASKS_DELETE"                                => true,
                "SUSTAINABILITY_SDG_REPORTING_EDIT"                                => true,
                "SUSTAINABILITY_SDG_REPORTING_VIEW"                                => true,
                "CHEMICAL_MNG_ASSIGNED_TASKS_CREATE"                               => true,
                "CHEMICAL_MNG_ASSIGNED_TASKS_DELETE"                               => true,
                "CHEMICAL_MNG_REQUEST_REGISTER_EDIT"                               => true,
                "CHEMICAL_MNG_REQUEST_REGISTER_VIEW"                               => true,
                "OCCUPATIONAL_HEALTH_DASHBOARD_VIEW"                               => true,
                "SUSTAINABILITY_SDG_REPORTING_CREATE"                              => true,
                "SUSTAINABILITY_SDG_REPORTING_DELETE"                              => true,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_EDIT"                             => true,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_VIEW"                             => true,
                "CHEMICAL_MNG_REQUEST_REGISTER_CREATE"                             => true,
                "CHEMICAL_MNG_REQUEST_REGISTER_DELETE"                             => true,
                "ENVIRONMENT_HISTORY_CONSUMPTION_EDIT"                             => true,
                "ENVIRONMENT_HISTORY_CONSUMPTION_VIEW"                             => true,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_CREATE"                           => true,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_DELETE"                           => true,
                "ENVIRONMENT_HISTORY_CONSUMPTION_CREATE"                           => true,
                "ENVIRONMENT_HISTORY_CONSUMPTION_DELETE"                           => true,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_EDIT"                          => true,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_VIEW"                          => true,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_EDIT"                         => true,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_VIEW"                         => true,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_EDIT"                         => true,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_VIEW"                         => true,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_EDIT"                         => true,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_VIEW"                         => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_EDIT"                        => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_VIEW"                        => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_EDIT"                        => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_VIEW"                        => true,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_CREATE"                        => true,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_DELETE"                        => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_EDIT"                       => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_VIEW"                       => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_EDIT"                       => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_VIEW"                       => true,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_CREATE"                       => true,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_DELETE"                       => true,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_CREATE"                       => true,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_DELETE"                       => true,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_CREATE"                       => true,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_DELETE"                       => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_CREATE"                      => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_DELETE"                      => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_CREATE"                      => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_DELETE"                      => true,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_EDIT"                      => true,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_VIEW"                      => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_CREATE"                     => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_DELETE"                     => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_CREATE"                     => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_DELETE"                     => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_EDIT"                    => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_VIEW"                    => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_EDIT"                    => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_VIEW"                    => true,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_CREATE"                    => true,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_DELETE"                    => true,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_EDIT"                   => true,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_VIEW"                   => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_EDIT"                   => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_VIEW"                   => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_EDIT"                   => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_VIEW"                   => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_CREATE"                  => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_DELETE"                  => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_CREATE"                  => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_DELETE"                  => true,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_CREATE"                 => true,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_DELETE"                 => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_CREATE"                 => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_DELETE"                 => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_CREATE"                 => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_DELETE"                 => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_EDIT"             => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_VIEW"             => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_EDIT"           => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_VIEW"           => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_EDIT"           => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_VIEW"           => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_CREATE"           => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_DELETE"           => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_EDIT"           => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_VIEW"           => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_EDIT"           => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_VIEW"           => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_EDIT"          => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_VIEW"          => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_EDIT"          => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_VIEW"          => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_CREATE"         => true,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_DELETE"         => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_CREATE"         => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_DELETE"         => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_CREATE"         => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_DELETE"         => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_EDIT"         => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_VIEW"         => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_CREATE"         => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_DELETE"         => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_CREATE"        => true,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_DELETE"        => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_CREATE"        => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_DELETE"        => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_CREATE"       => true,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_DELETE"       => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_EDIT"       => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_VIEW"       => true,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_EDIT"      => true,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_VIEW"      => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_CREATE"     => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_DELETE"     => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_EDIT"     => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_VIEW"     => true,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_CREATE"    => true,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_DELETE"    => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_CREATE"   => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_DELETE"   => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_EDIT"   => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_VIEW"   => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_CREATE" => true,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_DELETE" => true,

            ]),
        ]);

        ComPermission::factory()->create([
            'id'               => 2,
            'userType'         => 'guest',
            'description'      => 'guest Role with full permissions',
            'permissionObject' => ([
                "INSIGHT_VIEW"                                                     => true,
                "ADMIN_USERS_EDIT"                                                 => false,
                "ADMIN_USERS_VIEW"                                                 => false,
                "RAG_REGISTER_EDIT"                                                => false,
                "RAG_REGISTER_VIEW"                                                => false,
                "ADMIN_USERS_DELETE"                                               => false,
                "RAG_DASHBOARD_EDIT"                                               => false,
                "RAG_DASHBOARD_VIEW"                                               => false,
                "RAG_REGISTER_CREATE"                                              => false,
                "RAG_REGISTER_DELETE"                                              => false,
                "RAG_DASHBOARD_CREATE"                                             => false,
                "RAG_DASHBOARD_DELETE"                                             => false,
                "ADMIN_ACCESS_MNG_EDIT"                                            => false,
                "ADMIN_ACCESS_MNG_VIEW"                                            => false,
                "DOCUMENT_REGISTER_EDIT"                                           => false,
                "DOCUMENT_REGISTER_VIEW"                                           => false,
                "ADMIN_ACCESS_MNG_CREATE"                                          => false,
                "ADMIN_ACCESS_MNG_DELETE"                                          => false,
                "ATTRITION_REGISTER_EDIT"                                          => false,
                "ATTRITION_REGISTER_VIEW"                                          => false,
                "GRIEVANCE_REGISTER_EDIT"                                          => false,
                "GRIEVANCE_REGISTER_VIEW"                                          => false,
                "RAG_ASSIGNED_TASKS_EDIT"                                          => false,
                "RAG_ASSIGNED_TASKS_VIEW"                                          => false,
                "DOCUMENT_REGISTER_CREATE"                                         => false,
                "DOCUMENT_REGISTER_DELETE"                                         => false,
                "ENGAGEMENT_REGISTER_EDIT"                                         => false,
                "ENGAGEMENT_REGISTER_VIEW"                                         => false,
                "GRIEVANCE_DASHBOARD_VIEW"                                         => false,
                "SATISFACTION_SURVEY_EDIT"                                         => false,
                "SATISFACTION_SURVEY_VIEW"                                         => false,
                "ATTRITION_REGISTER_CREATE"                                        => false,
                "ATTRITION_REGISTER_DELETE"                                        => false,
                "GRIEVANCE_REGISTER_CREATE"                                        => false,
                "GRIEVANCE_REGISTER_DELETE"                                        => false,
                "HAZARD_RISK_REGISTER_EDIT"                                        => false,
                "HAZARD_RISK_REGISTER_VIEW"                                        => false,
                "RAG_ASSIGNED_TASKS_CREATE"                                        => false,
                "RAG_ASSIGNED_TASKS_DELETE"                                        => false,
                "ENGAGEMENT_REGISTER_CREATE"                                       => false,
                "ENGAGEMENT_REGISTER_DELETE"                                       => false,
                "ENVIRONMENT_DASHBOARD_VIEW"                                       => false,
                "HAZARD_RISK_DASHBOARD_VIEW"                                       => false,
                "SATISFACTION_SURVEY_CREATE"                                       => false,
                "SATISFACTION_SURVEY_DELETE"                                       => false,
                "CHEMICAL_MNG_DASHBOARD_VIEW"                                      => false,
                "HAZARD_RISK_REGISTER_CREATE"                                      => false,
                "HAZARD_RISK_REGISTER_DELETE"                                      => false,
                "CHEMICAL_MNG_TRANSACTION_EDIT"                                    => false,
                "CHEMICAL_MNG_TRANSACTION_VIEW"                                    => false,
                "GRIEVANCE_ASSIGNED_TASKS_EDIT"                                    => false,
                "GRIEVANCE_ASSIGNED_TASKS_VIEW"                                    => false,
                "AUDIT_INSPECTION_CALENDAR_EDIT"                                   => false,
                "AUDIT_INSPECTION_CALENDAR_VIEW"                                   => false,
                "AUDIT_INSPECTION_DASHBOARD_EDIT"                                  => false,
                "AUDIT_INSPECTION_DASHBOARD_VIEW"                                  => false,
                "CHEMICAL_MNG_TRANSACTION_CREATE"                                  => false,
                "CHEMICAL_MNG_TRANSACTION_DELETE"                                  => false,
                "GRIEVANCE_ASSIGNED_TASKS_CREATE"                                  => false,
                "GRIEVANCE_ASSIGNED_TASKS_DELETE"                                  => false,
                "HAZARD_RISK_ASSIGNED_TASKS_EDIT"                                  => false,
                "HAZARD_RISK_ASSIGNED_TASKS_VIEW"                                  => false,
                "AUDIT_INSPECTION_CALENDAR_CREATE"                                 => false,
                "AUDIT_INSPECTION_CALENDAR_DELETE"                                 => false,
                "CHEMICAL_MNG_ASSIGNED_TASKS_EDIT"                                 => false,
                "CHEMICAL_MNG_ASSIGNED_TASKS_VIEW"                                 => false,
                "INCIDENT_ACCIDENT_DASHBOARD_VIEW"                                 => false,
                "AUDIT_INSPECTION_DASHBOARD_CREATE"                                => false,
                "AUDIT_INSPECTION_DASHBOARD_DELETE"                                => false,
                "HAZARD_RISK_ASSIGNED_TASKS_CREATE"                                => false,
                "HAZARD_RISK_ASSIGNED_TASKS_DELETE"                                => false,
                "SUSTAINABILITY_SDG_REPORTING_EDIT"                                => false,
                "SUSTAINABILITY_SDG_REPORTING_VIEW"                                => false,
                "CHEMICAL_MNG_ASSIGNED_TASKS_CREATE"                               => false,
                "CHEMICAL_MNG_ASSIGNED_TASKS_DELETE"                               => false,
                "CHEMICAL_MNG_REQUEST_REGISTER_EDIT"                               => false,
                "CHEMICAL_MNG_REQUEST_REGISTER_VIEW"                               => false,
                "OCCUPATIONAL_HEALTH_DASHBOARD_VIEW"                               => false,
                "SUSTAINABILITY_SDG_REPORTING_CREATE"                              => false,
                "SUSTAINABILITY_SDG_REPORTING_DELETE"                              => false,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_EDIT"                             => false,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_VIEW"                             => false,
                "CHEMICAL_MNG_REQUEST_REGISTER_CREATE"                             => false,
                "CHEMICAL_MNG_REQUEST_REGISTER_DELETE"                             => false,
                "ENVIRONMENT_HISTORY_CONSUMPTION_EDIT"                             => false,
                "ENVIRONMENT_HISTORY_CONSUMPTION_VIEW"                             => false,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_CREATE"                           => false,
                "CHEMICAL_MNG_PURCHASE_INVENTORY_DELETE"                           => false,
                "ENVIRONMENT_HISTORY_CONSUMPTION_CREATE"                           => false,
                "ENVIRONMENT_HISTORY_CONSUMPTION_DELETE"                           => false,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_EDIT"                          => false,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_VIEW"                          => false,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_EDIT"                         => false,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_VIEW"                         => false,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_EDIT"                         => false,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_VIEW"                         => false,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_EDIT"                         => false,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_VIEW"                         => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_EDIT"                        => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_VIEW"                        => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_EDIT"                        => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_VIEW"                        => false,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_CREATE"                        => false,
                "ENVIRONMENT_HISTORY_TARGET_SETTING_DELETE"                        => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_EDIT"                       => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_VIEW"                       => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_EDIT"                       => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_VIEW"                       => false,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_CREATE"                       => false,
                "INCIDENT_ACCIDENT_CORRECTIVE_ACTION_DELETE"                       => false,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_CREATE"                       => false,
                "INCIDENT_ACCIDENT_REGISTER_ACCIDENT_DELETE"                       => false,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_CREATE"                       => false,
                "INCIDENT_ACCIDENT_REGISTER_INCIDENT_DELETE"                       => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_CREATE"                      => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_TASK_DELETE"                      => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_CREATE"                      => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_DELETE"                      => false,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_EDIT"                      => false,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_VIEW"                      => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_CREATE"                     => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_QUEUE_DELETE"                     => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_CREATE"                     => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_QUEUE_DELETE"                     => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_EDIT"                    => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_VIEW"                    => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_EDIT"                    => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_VIEW"                    => false,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_CREATE"                    => false,
                "ENVIRONMENT_ASSIGNED_TASKS_CONSUMPTION_DELETE"                    => false,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_EDIT"                   => false,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_VIEW"                   => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_EDIT"                   => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_VIEW"                   => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_EDIT"                   => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_VIEW"                   => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_CREATE"                  => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_REGISTER_DELETE"                  => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_CREATE"                  => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_DELETE"                  => false,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_CREATE"                 => false,
                "ENVIRONMENT_ASSIGNED_TASKS_TARGET_SETTING_DELETE"                 => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_CREATE"                 => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_ACCIDENT_DELETE"                 => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_CREATE"                 => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_INCIDENT_DELETE"                 => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_EDIT"             => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_VIEW"             => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_EDIT"           => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_VIEW"           => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_EDIT"           => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_VIEW"           => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_CREATE"           => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_CONSULTATION_DELETE"           => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_EDIT"           => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_VIEW"           => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_EDIT"           => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_VIEW"           => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_EDIT"          => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_VIEW"          => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_EDIT"          => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_VIEW"          => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_CREATE"         => false,
                "AUDIT_INSPECTION_EXTERNAL_AUDIT_CORRECTIVE_ACTION_DELETE"         => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_CREATE"         => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_CORRECTIVE_ACTION_DELETE"         => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_CREATE"         => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_MEDICINE_STOCK_DELETE"         => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_EDIT"         => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_VIEW"         => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_CREATE"         => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PHARMACY_QUEUE_DELETE"         => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_CREATE"        => false,
                "INCIDENT_ACCIDENT_ASSIGNED_TASKS_CORRECTIVE_ACTION_DELETE"        => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_CREATE"        => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_TRANSACTION_DELETE"        => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_CREATE"       => false,
                "OCCUPATIONAL_HEALTH_CLINICAL_SUITE_PATIENT_REGISTER_DELETE"       => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_EDIT"       => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_VIEW"       => false,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_EDIT"      => false,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_VIEW"      => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_CREATE"     => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_ASSIGNED_TASKS_DELETE"     => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_EDIT"     => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_VIEW"     => false,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_CREATE"    => false,
                "OCCUPATIONAL_HEALTH_MEDICAL_RECORDS_MATERNITY_REGISTER_DELETE"    => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_CREATE"   => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_MEDICINE_REQUEST_DELETE"   => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_EDIT"   => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_VIEW"   => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_CREATE" => false,
                "OCCUPATIONAL_HEALTH_MEDICINE_INVENTORY_PURCHASE_INVENTORY_DELETE" => false,
            ]),
        ]);
        ComResponsibleSection::factory()->create([
            'id'            => 1,
            'sectionName'   => 'Hazard And Risk Section',
            'sectionCode'   => 'HRS',
            'responsibleId' => '1',
        ]);
        ComResponsibleSection::factory()->create([
            'id'            => 2,
            'sectionName'   => 'Accident Section',
            'sectionCode'   => 'As',
            'responsibleId' => '2',
        ]);
        ComResponsibleSection::factory()->create([
            'id'            => 3,
            'sectionName'   => 'Incident Section',
            'sectionCode'   => 'Is',
            'responsibleId' => '3',
        ]);
        ComResponsibleSection::factory()->create([
            'id'            => 4,
            'sectionName'   => 'Medicine Request Section',
            'sectionCode'   => 'MRS',
            'responsibleId' => '4',
        ]);
    }

}

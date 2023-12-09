<?php

namespace Database\Seeders;

use App\Models\admin\Module;
use Illuminate\Database\Seeder;
use App\Models\admin\ModuleAccess;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();
        ModuleAccess::truncate();
        $modules = [
            [
                "identifiers"   => "anggota",
                "name"          => "Anggota",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                ]
            ],
            [
                "identifiers"   => "berita",
                "name"          => "Berita",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "dokumentasi",
                "name"          => "Dokumentasi",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "eskul",
                "name"          => "Ekstrakurikuler",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                    [
                        "identifiers" => "force_delete",
                        "name"        => "Force Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "jadwal",
                "name"          => "Jadwal",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "jurusan",
                "name"          => "Jurusan",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "kelas",
                "name"          => "Kelas",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "setting_kepala_sekolah",
                "name"          => "Setting Kepala Sekolah",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ]
                ]
            ],
            [
                "identifiers"   => "log_system",
                "name"          => "Log System",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "clear",
                        "name"        => "Clear",
                    ],
                    [
                        "identifiers" => "export",
                        "name"        => "Export",
                    ]
                ]
            ],
            [
                "identifiers"   => "module_management",
                "name"          => "Module Management",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "pendaftaran",
                "name"          => "Pendaftaran",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "status",
                        "name"        => "Status",
                    ]
                ]
            ],
            [
                "identifiers"   => "sekbid",
                "name"          => "Sekbid",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ]
                ]
            ],
            [
                "identifiers"   => "setting_general",
                "name"          => "Setting General",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                ]
            ],
            [
                "identifiers"   => "setting_pendaftaran",
                "name"          => "Setting Pendaftaran",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                ]
            ],
            [
                "identifiers"   => "user",
                "name"          => "User",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "status",
                        "name"        => "Status",
                    ],
                    [
                        "identifiers" => "arsip",
                        "name"        => "Arsip",
                    ],
                    [
                        "identifiers" => "restore",
                        "name"        => "Restore",
                    ],
                    [
                        "identifiers" => "force_delete",
                        "name"        => "Force Delete",
                    ]
                ]
            ],
            [
                "identifiers"   => "user_group",
                "name"          => "User Group",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "add",
                        "name"        => "Add",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                    [
                        "identifiers" => "delete",
                        "name"        => "Delete",
                    ],
                    [
                        "identifiers" => "detail",
                        "name"        => "Detail",
                    ],
                    [
                        "identifiers" => "status",
                        "name"        => "Status",
                    ]
                ]
            ],
            [
                "identifiers"   => "setting_wakil_kepala_sekolah",
                "name"          => "Setting Wakil Kepala Sekolah",
                "access"        => [
                    [
                        "identifiers" => "view",
                        "name"        => "View",
                    ],
                    [
                        "identifiers" => "edit",
                        "name"        => "Edit",
                    ],
                ]
            ],
        ];


        foreach ($modules as $data) {
            $data_access = $data['access'];
            $data_module = [
                "identifiers"   => $data["identifiers"],
                "name"          => $data["name"]
            ];
            $module = Module::create($data_module);
            foreach ($data_access as $row) {
                $module->access()->create([
                    "identifiers" => $row["identifiers"],
                    "name"        => $row["name"]
                ]);
            }
        }
    }
}

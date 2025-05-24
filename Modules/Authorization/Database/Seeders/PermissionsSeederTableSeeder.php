<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Authorization\Entities\Permission;

class PermissionsSeederTableSeeder extends Seeder
{
    private $extraPermissions = ["courses", "lessons", "lessoncontents", "services", "blogs", "coupons", "order_statuses", "orders"];

    private $permissions = [
        "dashboard_access" => [
            "routes" => "dashboard.home",
            "category" => "access",
            "title_en" => "Dashboard App Lawyer",
            "title_ar" => " عرض لوحة  تحكم صاحب التطبيق",
        ],
        "statistics_access" => [
            "routes" => "",
            "category" => "access statistics",
            "title_en" => "Show Statistics",
            "title_ar" => " عرض الاحصائيات",
        ],
        "lawyer_access" => [
            "routes" => "",
            "category" => "lawyers",
            "title_en" => "Dashboard  lawyer",
            "title_ar" => "  عرض لوحة   تحكم  المحامين",
        ],

        "instructor" => [
            "routes" => "",
            "category" => "instructor",
            "title_en" => "instructor",
            "title_ar" => "المحاضر",
        ],
        "show_roles" => [
            "routes" => "",
            "category" => "roles",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_roles" => [
            "routes" => "",
            "category" => "roles",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_roles" => [
            "routes" => "",
            "category" => "roles",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_roles" => [
            "routes" => "",
            "category" => "roles",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_users" => [
            "routes" => "",
            "category" => "users",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_users" => [
            "routes" => "",
            "category" => "users",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_users" => [
            "routes" => "",
            "category" => "users",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_users" => [
            "routes" => "",
            "category" => "users",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_admins" => [
            "routes" => "",
            "category" => "admins",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_admins" => [
            "routes" => "",
            "category" => "admins",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_admins" => [
            "routes" => "",
            "category" => "admins",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_admins" => [
            "routes" => "",
            "category" => "admins",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_lawyers" => [
            "routes" => "",
            "category" => "lawyers",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_lawyers" => [
            "routes" => "",
            "category" => "lawyers",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_lawyers" => [
            "routes" => "",
            "category" => "lawyers",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_lawyers" => [
            "routes" => "",
            "category" => "lawyers",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_pages" => [
            "routes" => "",
            "category" => "pages",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_pages" => [
            "routes" => "",
            "category" => "pages",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_pages" => [
            "routes" => "",
            "category" => "pages",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_pages" => [
            "routes" => "",
            "category" => "pages",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "edit_settings" => [
            "routes" => "",
            "category" => "settings",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "show_settings" => [
            "routes" => "",
            "category" => "settings",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "send_notifications" => [
            "routes" => "",
            "category" => "notifications",
            "title_en" => "Send",
            "title_ar" => "إرسال",
        ],
        "show_notifications" => [
            "routes" => "dashboard.notifications.index,dashboard.notifications.datatable,dashboard.notifications.show",
            "category" => "notifications",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "delete_notifications" => [
            "routes" => "dashboard.notifications.deletes,dashboard.notifications.destroy",
            "category" => "notifications",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "add_notifications" => [
            "routes" => "",
            "category" => "notifications",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "add_categories" => [
            "routes" => "dashboard.categories.create,dashboard.categories.store",
            "category" => "categories",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_categories" => [
            "routes" => "dashboard.categories.edit,dashboard.categories.update",
            "category" => "categories",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_categories" => [
            "routes" => "dashboard.categories.deletes,dashboard.categories.destroy",
            "category" => "categories",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_categories" => [
            "routes" => "dashboard.categories.index,dashboard.categories.datatable,dashboard.categories.show",
            "category" => "categories",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_countries" => [
            "routes" => "dashboard.countries.create,dashboard.countries.store",
            "category" => "countries",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_countries" => [
            "routes" => "dashboard.countries.edit,dashboard.countries.update",
            "category" => "countries",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_countries" => [
            "routes" => "dashboard.countries.deletes,dashboard.countries.destroy",
            "category" => "countries",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],

        "show_countries" => [
            "routes" => "dashboard.countries.index,dashboard.countries.datatable,dashboard.countries.show",
            "category" => "countries",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],


        "add_cities" => [
            "routes" => "dashboard.cities.create,dashboard.cities.store",
            "category" => "cities",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_cities" => [
            "routes" => "dashboard.cities.edit,dashboard.cities.update",
            "category" => "cities",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_cities" => [
            "routes" => "dashboard.cities.deletes,dashboard.cities.destroy",
            "category" => "cities",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_cities" => [
            "routes" => "dashboard.cities.index,dashboard.cities.datatable,dashboard.cities.show",
            "category" => "cities",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],

        "add_states" => [
            "routes" => "dashboard.states.create,dashboard.states.store",
            "category" => "states",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_states" => [
            "routes" => "dashboard.states.edit,dashboard.states.update",
            "category" => "states",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_states" => [
            "routes" => "dashboard.states.deletes,dashboard.states.destroy",
            "category" => "states",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_states" => [
            "routes" => "dashboard.states.index,dashboard.states.datatable,dashboard.states.show",
            "category" => "states",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "delete_logs" => [
            "routes" => "dashboard.logs.deletes,dashboard.logs.destroy",
            "category" => "logs",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_logs" => [
            "routes" => "dashboard.logs.index,dashboard.logs.datatable,dashboard.logs.show",
            "category" => "logs",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "delete_devices" => [
            "routes" => "dashboard.devices.deletes,dashboard.devices.destroy",
            "category" => "devices",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_devices" => [
            "routes" => "dashboard.devices.index,dashboard.devices.datatable,dashboard.devices.show",
            "category" => "devices",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "add_reservations" => [
            "routes" => "dashboard.reservations.create,dashboard.reservations.store",
            "category" => "reservations",
            "title_en" => "Add",
            "title_ar" => "إضافة",
        ],
        "edit_reservations" => [
            "routes" => "dashboard.reservations.edit,dashboard.reservations.update",
            "category" => "reservations",
            "title_en" => "Edit",
            "title_ar" => "تعديل",
        ],
        "delete_reservations" => [
            "routes" => "dashboard.reservations.deletes,dashboard.reservations.destroy",
            "category" => "reservations",
            "title_en" => "Delete",
            "title_ar" => "حذف",
        ],
        "show_reservations" => [
            "routes" => "dashboard.reservations.index,dashboard.reservations.datatable,dashboard.reservations.show",
            "category" => "reservations",
            "title_en" => "Show",
            "title_ar" => "عرض",
        ],
        "sales_report_by_lawyer" => [
            "routes" => "",
            "category" => "reports",
            "title_en" => "sales report by lawyer",
            "title_ar" => "تقارير البيع ل المحام",
        ],

    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->handelExtraPermissions(collect($this->permissions));
        foreach ($data as $name => $per_data) {
            $perm = Permission::updateOrCreate([
                "name" => $name,
            ], [
                "name" => $name,
                "category" => $per_data["category"],
                "guard_name" => "web",
                "routes" => $per_data["routes"],
                "display_name" => ["en" => $per_data["title_en"], "ar" => $per_data["title_ar"]]
            ]);
            $perm->save();
        }
    }


    public function handelExtraPermissions($permissions)
    {
        $data = $permissions;
        foreach ($this->extraPermissions  as  $model) {
            $data["add_$model"]   = [
                "routes" => "dashboard.$model.create,dashboard.$model.store",
                "category" => "$model",
                "title_en" => "Add",
                "title_ar" => "إضافة",
            ];
            $data["edit_$model"] = [
                "routes" => "dashboard.$model.edit,dashboard.$model.update",
                "category" => "$model",
                "title_en" => "Edit",
                "title_ar" => "تعديل",
            ];
            $data["delete_$model"] = [
                "routes" => "dashboard.$model.deletes,dashboard.$model.destroy",
                "category" => "$model",
                "title_en" => "Delete",
                "title_ar" => "حذف",
            ];
            $data["show_$model"] = [
                "routes" => "dashboard.$model.index,dashboard.$model.datatable,dashboard.$model.show",
                "category" => "$model",
                "title_en" => "Show",
                "title_ar" => "عرض",
            ];
        }
        return $data;
    }
}

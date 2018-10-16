<?php

namespace App\Containers\Plan\Data\Seeders;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Company\Models\Company;
use App\Containers\Invitation\Models\Invitation;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\Report\Models\Report;
use App\Containers\ReportDepart\Models\ReportDepart;
use App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion;
use App\Containers\User\Models\User;
use App\Ship\Parents\Seeders\Seeder;

/**
 * Class UserPermissionsSeeder_1
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Permissions ----------------------------------------------------------
        Apiato::call('Authorization@CreatePermissionTask', [
            'manage-plans',
            '方案管理'
        ]);
        Apiato::call('Authorization@CreatePermissionTask', [
            'manage-parent_plans',
            '标准库管理'
        ]);

        factory(Plan::class, 20)->create();

        $companies_ids = Company::all()->pluck('id')->toArray();
        $plan_ids = Plan::all()->pluck('id')->toArray();

        foreach ($plan_ids as $plan_id) {

            $plan_depart = factory(PlanDepart::class)->create([
                'plan_id' => $plan_id,
            ]);

            factory(PlanDepartQuestion::class, 10)->create([
                'plan_depart_id' => $plan_depart->id,
            ]);

            factory(Order::class)->create([
                'status'     => '已完成',
                'plan_id'    => $plan_id,
                'company_id' => array_random($companies_ids),
            ]);

        }

        $plan = factory(Plan::class)->create([
            'is_parent' => true
        ]);

        $planParentDeparts = factory(PlanDepart::class, 10)->create([
            'plan_id' => $plan->id,
        ]);

        foreach ($planParentDeparts as $planParentDepart) {

            factory(PlanDepartQuestion::class)->create([
                'plan_depart_id' => $planParentDepart->id,
            ]);

        }

        $order = Order::first();
        $user_ids = User::all()->pluck('id')->toArray();
        $order->company->users()->sync($user_ids);

        $depart_ids = $order->plan->plan_departs->pluck('id')->toArray();

        $reports = factory(Report::class, 20)->create([
            'order_id' => $order->id
        ]);

        $report_departs = factory(ReportDepart::class, 20)->create([
            'report_id' => $reports->first()->id
        ]);

        factory(ReportDepartQuestion::class, 20)->create([
            'report_depart_id' => $report_departs->first()->id
        ]);

        factory(Invitation::class, 20)->create([
            'depart_ids' => $depart_ids,
            'report_id'  => $reports->first()->id,
        ]);

        User::first()->invitations()->attach(Invitation::first()->id, ['is_client' => false]);

        // ...

    }
}

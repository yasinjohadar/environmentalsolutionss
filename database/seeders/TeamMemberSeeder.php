<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['name' => 'شفق نور', 'title' => 'مدير قسم الاستدامة', 'order' => 1],
            ['name' => 'وردة شافي', 'title' => 'خبير إعادة التدوير', 'order' => 2],
            ['name' => 'كورتني هنري', 'title' => 'الرئيس التنفيذي', 'order' => 3],
            ['name' => 'أحمد محمد', 'title' => 'مدير العمليات', 'order' => 4],
            ['name' => 'سارة العلي', 'title' => 'مديرة التقنية', 'order' => 5],
            ['name' => 'خالد الشمري', 'title' => 'خبير إعادة التدوير', 'order' => 6],
        ];

        foreach ($members as $data) {
            TeamMember::create([
                'name' => $data['name'],
                'title' => $data['title'],
                'image' => null,
                'order' => $data['order'],
                'is_active' => true,
            ]);
        }

        $this->command->info('تم إنشاء 6 أعضاء فريق بنجاح.');
    }
}

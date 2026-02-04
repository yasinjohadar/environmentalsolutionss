<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = Product::pluck('id')->toArray();
        if (empty($productIds)) {
            $this->command->warn('لا توجد منتجات. قم بتشغيل CategoryAndProductSeeder أولاً.');
            return;
        }

        $testimonials = [
            [
                'client_name' => 'أحمد محمد العلي',
                'client_title' => 'مدير عام شركة التقنية المتكاملة',
                'comment' => 'تعاملنا مع الفريق لسنوات في التخلص من أجهزتنا الإلكترونية القديمة. خدمة احترافية ومضمونة، مع ضمان إتلاف البيانات بشكل آمن.',
                'rating' => 5,
            ],
            [
                'client_name' => 'سارة عبدالله',
                'client_title' => 'مديرة الموارد البشرية',
                'comment' => 'حل مثالي لشركتنا. وفرنا مساحة وتخلصنا من مئات الأجهزة بأمان. أنصح به بشدة لأي مؤسسة.',
                'rating' => 5,
            ],
            [
                'client_name' => 'خالد بن سعيد',
                'client_title' => 'مدير تقنية المعلومات',
                'comment' => 'المعايير البيئية والالتزام بالمواعيد ممتاز. فريق محترف وفهم عميق لاحتياجات القطاع.',
                'rating' => 5,
            ],
            [
                'client_name' => 'فاطمة علي حسن',
                'client_title' => 'مالكة مكتب محاسبة',
                'comment' => 'خدمة سريعة وآمنة. تعاملنا معهم للتخلص من أجهزة الكمبيوتر القديمة وكانت التجربة ممتازة.',
                'rating' => 5,
            ],
            [
                'client_name' => 'عمر يوسف',
                'client_title' => 'شريك تعاون',
                'comment' => 'نفخر بمشاركة قصص نجاح عملائنا. ملاحظاتهم تعكس التزامنا بالتميز وجودة خدماتنا في إعادة تدوير النفايات الإلكترونية.',
                'rating' => 5,
            ],
            [
                'client_name' => 'نورة سالم',
                'client_title' => 'مديرة قسم الاستدامة',
                'comment' => 'ساعدونا في تحقيق أهدافنا البيئية. التخلص الآمن من النفايات الإلكترونية كان جزءاً أساسياً من استراتيجيتنا.',
                'rating' => 5,
            ],
            [
                'client_name' => 'محمود إبراهيم',
                'client_title' => 'مدير مؤسسة',
                'comment' => 'خدمة استثنائية في الجمع والنقل. يغطون جميع أنحاء المملكة وهذا ما نحتاجه.',
                'rating' => 5,
            ],
            [
                'client_name' => 'هند عبدالرحمن',
                'client_title' => 'مسؤولة المشتريات',
                'comment' => 'أسعار تنافسية وموثوقية عالية. نتعامل معهم بشكل دوري وكل مرة تجربة أفضل.',
                'rating' => 4,
            ],
            [
                'client_name' => 'ياسر القحطاني',
                'client_title' => 'الرئيس التنفيذي',
                'comment' => 'شركاء موثوقون في مسيرتنا نحو الاستدامة. نوصي بخدماتهم لكل من يهتم بالبيئة.',
                'rating' => 5,
            ],
            [
                'client_name' => 'لمياء أحمد',
                'client_title' => 'مديرة العمليات',
                'comment' => 'عمل منظم ومحترف. شهاداتهم المعتمدة تطمئننا أننا نتعامل مع جهة موثوقة.',
                'rating' => 5,
            ],
            [
                'client_name' => 'عادل محمد',
                'client_title' => 'مدير صيانة الأجهزة',
                'comment' => 'جمعوا أكثر من 500 جهاز من فروعنا خلال أسبوع. كفاءة وإتقان في الأداء.',
                'rating' => 5,
            ],
            [
                'client_name' => 'ريم عبدالعزيز',
                'client_title' => 'استشارية بيئية',
                'comment' => 'أوصيت بعدة شركات بالتعامل معهم. التزامهم بالمعايير البيئية يجعلهم الخيار الأمثل.',
                'rating' => 5,
            ],
            [
                'client_name' => 'وليد الشمري',
                'client_title' => 'مدير تقنية المعلومات',
                'comment' => 'التخلص الآمن من البيانات كان أولويتنا. أثبتوا جدارتهم ونسعى لتوسيع التعاون.',
                'rating' => 5,
            ],
            [
                'client_name' => 'ابتسام خالد',
                'client_title' => 'شريك تعاون',
                'comment' => 'تجربة إيجابية من البداية للنهاية. فريق ودود ومحترف يفهم احتياجات العملاء.',
                'rating' => 5,
            ],
            [
                'client_name' => 'فيصل العتيبي',
                'client_title' => 'مدير عام',
                'comment' => 'خدمة ضرورية لأي شركة لديها أجهزة قديمة. وفرنا الكثير بفضل حلولهم المتكاملة.',
                'rating' => 4,
            ],
            [
                'client_name' => 'جواهر المطيري',
                'client_title' => 'مديرة التسويق',
                'comment' => 'تعزيز صورة شركتنا البيئية بفضل الشراكات مع جهات مثلكم. شكراً للفريق.',
                'rating' => 5,
            ],
            [
                'client_name' => 'رائد الشهري',
                'client_title' => 'مدير المشتريات',
                'comment' => 'تعاقدنا معهم لسنوات قادمة. ثقة مبنية على تجربة حقيقية وجودة ثابتة.',
                'rating' => 5,
            ],
            [
                'client_name' => 'أمل الزهراني',
                'client_title' => 'مسؤولة البيئة',
                'comment' => 'الإبلاغ والتوثيق دقيقان. يساعدنا ذلك في تقارير الاستدامة السنوية.',
                'rating' => 5,
            ],
            [
                'client_name' => 'سامي الدوسري',
                'client_title' => 'مدير تقنية',
                'comment' => 'سرعة الاستجابة والتنسيق مع فروعنا المتعددة مميزة. خدمة تعتمد عليها.',
                'rating' => 5,
            ],
            [
                'client_name' => 'منى العسيري',
                'client_title' => 'مديرة مؤسسة تعليمية',
                'comment' => 'تخلصنا من مختبرات الحاسوب القديمة بأمان. فريق محترف يفهم خصوصية المؤسسات التعليمية.',
                'rating' => 5,
            ],
        ];

        $productIndex = 0;
        $productCount = count($productIds);

        foreach ($testimonials as $index => $data) {
            $productId = $productIds[$productIndex % $productCount];
            $productIndex++;

            Review::create([
                'product_id' => $productId,
                'user_id' => null,
                'rating' => $data['rating'],
                'title' => 'تجربة ممتازة في إعادة التدوير',
                'client_name' => $data['client_name'],
                'client_title' => $data['client_title'],
                'comment' => $data['comment'],
                'status' => 'approved',
                'is_verified_purchase' => (bool) rand(0, 1),
                'is_featured' => true,
            ]);
        }

        $this->command->info('تم إنشاء 20 رأي عملاء بنجاح.');
    }
}

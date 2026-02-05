<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    protected $fillable = ['content'];

    protected $casts = [
        'content' => 'array',
    ];

    /**
     * Get the singleton instance.
     */
    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], ['content' => null]);
    }

    /**
     * Get merged content (saved + defaults). Returns array with relative image paths and texts.
     */
    public static function getContent(): array
    {
        $row = static::first();
        $saved = is_array($row->content ?? null) ? $row->content : [];
        return array_replace_recursive(static::defaultContent(), $saved);
    }

    /**
     * Resolve image path to full URL (for frontend display).
     */
    public static function imageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'http')) {
            return $path;
        }
        if (str_starts_with($path, 'frontend/')) {
            return asset($path);
        }
        return asset('storage/' . $path);
    }

    /**
     * Default content (current static paths and texts from the homepage view).
     */
    public static function defaultContent(): array
    {
        $base = 'frontend/assets/img/HomeCone';
        $slider = 'frontend/assets/img/slider';
        $gallery = 'frontend/assets/img/gallery';

        return [
            'banner_fallback' => [
                'image' => $slider . '/slide1.webp',
                'arrow_icon' => $base . '/icon/arrow-icon.png',
                'cross_shape' => $base . '/shape/cross-shape.png',
                'subtitle' => 'نحن خبراء في المجال',
                'title' => 'حلول متكاملة إعادة تدوير النفايات الإلكترونية',
                'title_highlight' => 'إعادة تدوير',
                'description' => 'نقدم خدمات شاملة لجمع وإعادة تدوير النفايات الإلكترونية بطرق آمنة وصديقة للبيئة.',
                'button1_text' => 'اكتشف المزيد',
                'button1_url' => 'project.html',
                'button2_text' => 'من نحن',
                'button2_url' => '',
            ],
            'sidemenu_gallery' => [
                $gallery . '/1.jpg',
                $gallery . '/2.jpg',
                $gallery . '/3.jpg',
                $gallery . '/4.jpg',
            ],
            'services' => [
                'arrow_icon' => $base . '/icon/arrow-icon-two.png',
                'section_subtitle' => 'نحن خبراء في المجال',
                'section_title' => 'خدمات إعادة تدوير النفايات الإلكترونية',
                'section_description' => 'نقدم حلولاً متكاملة وآمنة لإدارة النفايات الإلكترونية، مع ضمان الامتثال للمعايير البيئية وضمان التخلص الآمن من البيانات الحساسة.',
            ],
            'choose_us' => [
                'image1' => $base . '/choose-us-img1.png',
                'image2' => $base . '/choose-us-img2.png',
                'people_images' => [
                    $base . '/people-img1.png',
                    $base . '/people-img2.png',
                    $base . '/people-img3.png',
                    $base . '/people-img4.png',
                    $base . '/people-img5.png',
                ],
                'arrow_icon' => $base . '/icon/arrow-icon-two.png',
                'title' => 'لماذا تختارنا',
                'section_title' => 'نحن الحل الأمثل لإدارة وإعادة تدوير النفايات الإلكترونية.',
                'description' => 'نقدم حلولاً متكاملة وآمنة تلبي احتياجات مؤسستكم، مع ضمان الامتثال للمعايير البيئية وحماية بياناتكم الحساسة بثقة تامة.',
                'video_image' => $base . '/video.png',
                'video_url' => 'https://www.youtube.com/watch?v=VCPGMjCW0is',
                'check_icon' => $base . '/check-icon.png',
                'mission' => [
                    'items' => [
                        'التزامنا بحماية البيئة والتقليل من البصمة الكربونية',
                        'إعادة تدوير 100% من النفايات الإلكترونية المستلمة',
                        'الإتلاف الآمن للبيانات الحساسة وفق أعلى المعايير',
                        'الشفافية والموثوقية في كل خطوة من العملية',
                    ],
                ],
                'approach' => [
                    'items' => [
                        'جمع النفايات من جميع أنحاء المملكة ودول الخليج',
                        'عمليات صديقة للبيئة ومعتمدة دولياً',
                        'توثيق كامل وشهادات التخلص الآمن',
                        'شراكات استراتيجية مع القطاعين العام والخاص',
                    ],
                ],
                'vision' => [
                    'items' => [
                        'ريادة في الاقتصاد الدائري والاستدامة',
                        'الوصول إلى صفر نفايات إلكترونية في المكبات',
                        'تعزيز ثقافة المسؤولية البيئية في المجتمع',
                        'الابتكار المستمر في تقنيات إعادة التدوير',
                    ],
                ],
            ],
            'portfolio' => [
                'bg_image' => $base . '/portfolio-bg.png',
                'play_icon' => $base . '/icon/play-icon.png',
                'description' => 'نعمل معكم بشكل وثيق لتطوير حلول متكاملة لإدارة النفايات الإلكترونية وتحقيق أهداف الاستدامة.',
                'image1' => $base . '/portfolio-img1.png',
                'image2' => $base . '/portfolio-img2.png',
                'image3' => $base . '/portfolio-img3.png',
            ],
            'about_section' => [
                'bg_image' => $base . '/about-bg.png',
                'arrow_icon' => $base . '/icon/arrow-icon-two.png',
                'subtitle' => 'من نحن',
                'title' => 'حلول متكاملة لإعادة تدوير النفايات الإلكترونية',
                'description' => 'نتبع نهجاً يراعي احتياجات كل عميل، ونعمل بشكل وثيق مع المؤسسات لفهم تحدياتهم وضمان التخلص الآمن والسليم من النفايات الإلكترونية.',
            ],
            'team' => [
                'arrow_icon' => $base . '/icon/arrow-icon-two.png',
                'subtitle' => 'تعرف على فريقنا',
                'title' => 'شركاء النجاح',
                'description' => 'فريقنا هو عماد نجاحنا، مكوّن من خبراء في مجال إعادة التدوير والاستدامة.',
                'default_image' => $base . '/team-img1.png',
            ],
            'work_process' => [
                'arrow_icon' => $base . '/icon/arrow-icon-two.png',
                'subtitle' => 'آلية عملنا',
                'title' => 'خطوات بسيطة للتخلص الآمن من النفايات الإلكترونية',
                'description' => 'نسير معكم خطوة بخطوة لضمان أفضل النتائج وفق احتياجاتكم، من الاتصال حتى استلام شهادة التخلص.',
                'main_image' => $base . '/work-process-img.png',
                'shape1' => $base . '/shape/work-process-shape1.png',
                'shape2' => $base . '/shape/work-process-shape2.png',
                'step_icon' => $base . '/icon/work-process-icon1.png',
            ],
            'testimonial' => [
                'arrow_icon' => $base . '/icon/arrow-icon-two.png',
                'subtitle' => 'ماذا يقول عملاؤنا',
                'title' => 'قصص نجاحنا',
                'description' => 'نفخر بتقديم نتائج استثنائية وخدمة متميزة لعملائنا. اكتشفوا تجارب من تعاملوا معنا.',
                'fallback_image' => $base . '/testimonial-image.png',
                'user_placeholder' => $base . '/user-img.png',
            ],
        ];
    }
}

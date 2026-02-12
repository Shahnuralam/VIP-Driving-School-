<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogDemoSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::first()?->id ?? 1;

        $categories = [
            ['name' => 'Driving Tips', 'description' => 'Practical tips for learner drivers', 'sort_order' => 1],
            ['name' => 'Road Rules', 'description' => 'Updates and explanations of Tasmanian road rules', 'sort_order' => 2],
            ['name' => 'Test Preparation', 'description' => 'Getting ready for your driving test', 'sort_order' => 3],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $c = BlogCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cat['name'])],
                array_merge($cat, ['is_active' => true])
            );
            $categoryIds[$cat['name']] = $c->id;
        }

        $posts = [
            [
                'title' => '5 Essential Tips for Your First Driving Lesson',
                'category' => 'Driving Tips',
                'excerpt' => 'Your first driving lesson can feel overwhelming. Here are five tips to help you get the most out of it and build confidence from day one.',
                'content' => '<p>Your first driving lesson is a big milestone. Here are five tips to make it a success:</p>
<ol>
<li><strong>Get a good sleep</strong> – Being well-rested helps you focus and react quickly.</li>
<li><strong>Wear comfortable shoes</strong> – Avoid thick soles or heels so you can feel the pedals properly.</li>
<li><strong>Ask questions</strong> – Your instructor is there to help. No question is too small.</li>
<li><strong>Stay calm</strong> – Everyone was a beginner once. Your instructor will guide you through each step.</li>
<li><strong>Review the basics</strong> – A quick look at the road rules the night before can help.</li>
</ol>
<p>At VIP Driving School we specialise in making first lessons relaxed and positive. Book your first lesson with us today!</p>',
                'tags' => ['first lesson', 'tips', 'beginners'],
                'featured' => true,
            ],
            [
                'title' => 'Understanding Give Way Rules in Tasmania',
                'category' => 'Road Rules',
                'excerpt' => 'Give way rules can be confusing. We break down the key rules you need to know for the Hobart area.',
                'content' => '<p>Give way rules are essential for safe driving. In Tasmania:</p>
<ul>
<li>You must give way to vehicles on your right at roundabouts.</li>
<li>When turning right, give way to oncoming vehicles going straight or turning left.</li>
<li>At a T-junction, vehicles on the continuing road have right of way.</li>
<li>Always give way to pedestrians at marked crossings.</li>
</ul>
<p>During your lessons we practice these situations in real traffic so they become second nature.</p>',
                'tags' => ['road rules', 'give way', 'roundabouts'],
                'featured' => true,
            ],
            [
                'title' => 'How to Prepare for Your P1 Practical Test',
                'category' => 'Test Preparation',
                'excerpt' => 'A step-by-step guide to preparing for your P1 driving test in Hobart.',
                'content' => '<p>Preparing for your P1 test? Follow these steps:</p>
<ol>
<li><strong>Book enough lessons</strong> – Most learners need 20–30 hours of professional instruction.</li>
<li><strong>Practice in test areas</strong> – Familiarise yourself with common test routes in Hobart.</li>
<li><strong>Know the test criteria</strong> – Your instructor can run through what the examiner looks for.</li>
<li><strong>Rest the night before</strong> – Avoid last-minute cramming.</li>
<li><strong>Arrive early</strong> – Give yourself time to relax before the test.</li>
</ol>
<p>We offer dedicated test preparation lessons and mock tests. Ask us when you book.</p>',
                'tags' => ['P1', 'test', 'preparation'],
                'featured' => true,
            ],
            [
                'title' => 'Manual vs Automatic: Which Should You Learn In?',
                'category' => 'Driving Tips',
                'excerpt' => 'The pros and cons of learning in a manual or automatic car, and what it means for your licence.',
                'content' => '<p>Choosing between manual and automatic is a common question.</p>
<p><strong>Automatic</strong> – Easier to learn, less to coordinate, and most new cars are automatic. Your licence will allow you to drive automatic only.</p>
<p><strong>Manual</strong> – More work to learn, but your licence will allow you to drive both manual and automatic. Useful if you might drive older or work vehicles.</p>
<p>We offer lessons in both. Talk to your instructor about your goals and we can recommend the best option for you.</p>',
                'tags' => ['manual', 'automatic', 'learner'],
                'featured' => false,
            ],
            [
                'title' => 'What to Bring to Your Driving Lesson',
                'category' => 'Driving Tips',
                'excerpt' => 'A simple checklist so you never forget anything important for your lesson.',
                'content' => '<p>Bring these to every lesson:</p>
<ul>
<li><strong>Learner licence</strong> – You must have it with you whenever you drive.</li>
<li><strong>Glasses or contacts</strong> – If your licence says you need to wear them.</li>
<li><strong>Comfortable shoes</strong> – Safe for operating the pedals.</li>
<li><strong>Water</strong> – Especially in summer.</li>
<li><strong>Any questions</strong> – Write them down so you remember to ask!</li>
</ul>
<p>Your instructor will have everything else – including the car and dual controls. Just bring yourself and your licence.</p>',
                'tags' => ['checklist', 'lesson', 'what to bring'],
                'featured' => false,
            ],
            [
                'title' => 'Hazard Perception: How to Spot Risks Early',
                'category' => 'Road Rules',
                'excerpt' => 'Improving your hazard perception makes you a safer driver and helps you pass the test.',
                'content' => '<p>Good hazard perception is one of the most important skills for safe driving.</p>
<p>Scan ahead, check mirrors regularly, and look for clues: brake lights, pedestrians near the kerb, cars in side streets, and changing road conditions.</p>
<p>During lessons we point out hazards in real time and practise the “commentary drive” technique to build your awareness. This is also part of the P1 assessment.</p>',
                'tags' => ['hazard perception', 'safety', 'P1'],
                'featured' => false,
            ],
        ];

        foreach ($posts as $p) {
            $categoryId = $categoryIds[$p['category']] ?? null;
            $post = BlogPost::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($p['title'])],
                [
                    'blog_category_id' => $categoryId,
                    'author_id' => $authorId,
                    'title' => $p['title'],
                    'excerpt' => $p['excerpt'],
                    'content' => $p['content'],
                    'status' => 'published',
                    'published_at' => now()->subDays(rand(1, 30)),
                    'allow_comments' => true,
                    'is_featured' => $p['featured'],
                    'reading_time' => 3,
                ]
            );
            $tagIds = [];
            foreach ($p['tags'] as $tagName) {
                $tag = BlogTag::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($tagName)],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        }
    }
}

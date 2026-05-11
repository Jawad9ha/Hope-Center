# Hope Center IT Asset Management System

## حل السيناريو الزمني (البند رقم 5)

**المشكلة:** موظف يريد إرجاع جهاز، وآخر يريد استعارته في نفس اللحظة.

**الحل المطبق:**

1. عند إرجاع الجهاز، لا يعود مباشرة إلى `available` بل إلى حالة وسيطة: `pending_inspection`.
2. الجهاز يظل في هذه الحالة حتى يقوم مسؤول الفحص بتغيير حالته يدوياً إلى `available` أو `under_maintenance`.
3. أثناء وجود الجهاز في `pending_inspection`، لا يظهر في قائمة الأجهزة المتاحة للإعارة.
4. عند اكتشاف ضرر، يتم تسجيل `DamageReport` مع اسم الموظف المسؤول عن الفحص (`inspected_by`).

**ضمان عدم التحايل:**  
نستخدم database transaction عند تحديث حالة الجهاز، وأي طلب إعارة متزامن سيفشل لأن حالة الجهاز لا تزال `pending_inspection`.

**معرفة المسؤول عن الضرر:**  
يتم تسجيل `inspected_by` في جدول `loans` و`reported_by` في جدول `damage_reports`.

## تشغيل المشروع

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Auth\UserBloodType;
use App\Models\Auth\UserGender;
use App\Models\Auth\UserMaritalStatus;
use App\Models\Auth\UserProfile;
use App\Models\Auth\UserConfirm;
use App\Models\Auth\UserIdentityType;
use App\Models\Core\Currency;
use App\Models\Core\Setting;
use App\Models\Core\Country;
use App\Models\Core\Province;
use App\Models\Core\Regency;
use App\Models\Core\District;
use App\Models\Core\Village;
use App\Models\Master\Bank;
use App\Models\Master\Contact;
use App\Models\Master\AbsenceType;
use App\Models\Master\AnnualType;
use App\Models\Master\AttachmentType;
use App\Models\Master\EducationQualification;
use App\Models\Master\Industries;
use App\Models\Master\Job;
use App\Models\Master\LossType;
use App\Models\Master\Specialization;
use App\Models\Master\EmployeeType;
use App\Models\Organization\Division;
use App\Models\Organization\Position;
use App\Models\Employees\Employee;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function coreSeed(){
        $this->seedCountries();
        $this->seedProvince();
        $this->seedRegency();
        $this->seedBank();
        $this->seedOrganizations();
        $this->seedContact();
        $this->seedAnnualType();
        $this->seedAbsenceType();
        $this->seedAttachmentType();
        $this->seedEducationQualification();
        $this->seedIndustries();
        $this->seedJob();
        $this->seedLossType();
        $this->seedSpecialization();
        $this->seedEmployeeType();
        $this->seedIdentityType();
        $this->seedCurrency();
    }

    private function seedCurrency(){
        $file_csv = base_path().'/data_seeds/currencies.csv';
        $file = fopen($file_csv,"r");
        while(!feof($file)){
            $row = fgetcsv($file);
            if(isset($row[0]) && !is_null($row[0])){
                Currency::create([
                    'entity'=> isset($row[0]) ? $row[0] : null,
                    'name'=> isset($row[1]) ? $row[1] : null,
                    'code1'=> isset($row[2]) ? $row[2] : null,
                    'code2'=> isset($row[3]) ? $row[3] : null,
                    'minor_unit'=> isset($row[4]) ? $row[4] : null,
                    'withdraw_date'=> isset($row[5]) ? $row[5] : null,
                ]);
            }
        }
        $this->command->info('Currencies has been imported..');
        fclose($file);
    }

    private function seedIdentityType(){
        $defaultValues = UserIdentityType::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            UserIdentityType::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedEmployeeType(){
        $defaultValues = EmployeeType::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            EmployeeType::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedSpecialization(){
        $defaultValues = Specialization::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            Specialization::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedLossType(){
        $defaultValues = LossType::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            LossType::create([
                "cost"=>rand(1,10),
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedJob(){
        $defaultValues = Job::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            $j = new Job();
            $code = $j->createCode("J");
            Job::create([
                "code"=>$code,
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedIndustries(){
        $defaultValues = Industries::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            Industries::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedEducationQualification(){
        $defaultValues = EducationQualification::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            EducationQualification::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedAttachmentType(){
        $defaultValues = AttachmentType::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            AttachmentType::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedAnnualType(){
        $defaultValues = AnnualType::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            AnnualType::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedAbsenceType(){
        $defaultValues = AbsenceType::defaultValues();
        foreach($defaultValues as $row){
            $faker = Faker::create();
            AbsenceType::create([
                'name'=>$row,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedContact(){
        for($i = 1; $i <= 25; $i++){
            $faker = Faker::create();
            Contact::create([
                'name'=>$faker->firstName." ".$faker->lastName,
                'email'=>$faker->unique()->safeEmail,
                'phone'=>$faker->phoneNumber,
                'website'=>$faker->safeEmailDomain,
                'postal_code'=>$faker->postcode,
                'address'=>$faker->streetAddress
            ]);
        }
    }


    private function seedBank(){
        $file_csv = base_path().'/data_seeds/banks.csv';
        $file = fopen($file_csv,"r");
        while(!feof($file)){
            $row = fgetcsv($file);
            $indonesia = Country::where("iso_code","ID")->first();
            if(isset($row[0]) && !is_null($row[0])){
                $faker = Faker::create();
                $name = isset($row[1]) ? $row[1] : null;
                $country_id = $indonesia->id;
                Bank::create([
                    'name'=>$name,
                    'country_id'=>$country_id,
                    'description'=>$faker->sentence
                ]);
            }
        }
        $this->command->info('Bank has been imported..');
        fclose($file);
    }

    private function seedOrganizations(){
        // Position
        $defaultPosition = Position::defaultPosition();
        foreach($defaultPosition as $position){
            $p = new Position();
            $code = $p->createCode("P");
            $faker = Faker::create();
            $salary = rand(300000,5000000);
            Position::create([
                'code'=>$code,
                'name'=>$position,
                'hour_salary'=>$salary,
                'level'=>1,
                'description'=>$faker->sentence
            ]);
        }
        // Divisions
        $defaultDivisions = Division::defaultDivision();
        foreach($defaultDivisions as $division){
            $d = new Division();
            $code = $d->createCode("D");
            $faker = Faker::create();
            Division::create([
                'code'=>$code,
                'name'=>$division,
                'description'=>$faker->sentence
            ]);
        }
    }

    private function seedVillage(){
        $file_csv = base_path().'/data_seeds/villages.csv';
        $file = fopen($file_csv,"r");
        while(!feof($file)){
            $row = fgetcsv($file);
            if(isset($row[0]) && !is_null($row[0])){
                $district_code = isset($row[1]) ? $row[1] : "";
                $district = District::where("code", $district_code)->first();
                $district_id = !is_null($district) ? $district->id : null;
                $code = isset($row[0]) ? $row[0] : "";
                $name = isset($row[2]) ? $row[2] : "";
                Village::create([
                    'district_id'=>$district_id,
                    'district_code'=>$district_code,
                    'code'=>$code,
                    'name'=>$name
                ]);
            }
        }
        $this->command->info('District has been imported..');
        fclose($file);
    }

    private function seedDistrict(){
        $file_csv = base_path().'/data_seeds/districts.csv';
        $file = fopen($file_csv,"r");
        while(!feof($file)){
            $row = fgetcsv($file);
            if(isset($row[0]) && !is_null($row[0])){
                $regency_code = isset($row[1]) ? $row[1] : "";
                $regency = Regency::where("code", $regency_code)->first();
                $regency_id = !is_null($regency) ? $regency->id : null;
                $code = isset($row[0]) ? $row[0] : "";
                $name = isset($row[2]) ? $row[2] : "";
                District::create([
                    'regency_id'=>$regency_id,
                    'regency_code'=>$regency_code,
                    'code'=>$code,
                    'name'=>$name
                ]);
            }
        }
        $this->command->info('District has been imported..');
        fclose($file);
    }

    private function seedRegency(){
        $file_csv = base_path().'/data_seeds/regencies.csv';
        $file = fopen($file_csv,"r");
        while(!feof($file)){
            $row = fgetcsv($file);
            if(isset($row[0]) && !is_null($row[0])){
                $province_code = isset($row[1]) ? $row[1] : "";
                $province = Province::where("code", $province_code)->first();
                $province_id = !is_null($province) ? $province->id : null;
                $code = isset($row[0]) ? $row[0] : "";
                $name = isset($row[2]) ? $row[2] : "";
                Regency::create([
                    'province_id'=>$province_id,
                    'province_code'=>$province_code,
                    'code'=>$code,
                    'name'=>$name
                ]);
            }
        }
        $this->command->info('Regency has been imported..');
        fclose($file);
    }

    private function seedProvince(){
        $indonesia = Country::where("iso_code","ID")->first();
        if(!is_null($indonesia)){
            $file_csv = base_path().'/data_seeds/provinces.csv';
            $file = fopen($file_csv,"r");
            while(!feof($file)){
                $row = fgetcsv($file);
                if(isset($row[0]) && !is_null($row[0])){
                    $country_id = $indonesia->id;
                    $code = isset($row[0]) ? $row[0] : "";
                    $name = isset($row[1]) ? $row[1] : "";
                    Province::create([
                        'country_id'=>$country_id,
                        'code'=>$code,
                        'name'=>$name
                    ]);
                }
            }
            fclose($file);
        }
        $this->command->info('Province has been imported..');
    }

    private function seedCountries(){
        $file_csv = base_path().'/data_seeds/countries.csv';
        $file = fopen($file_csv,"r");
        while(!feof($file)){
            $row = fgetcsv($file);
            if(isset($row[0]) && !is_null($row[0])){
                $name = isset($row[0]) ? $row[0] : "";
                $iso_code = isset($row[1]) ? $row[1] : "";
                Country::create([
                    "iso_code"=>$iso_code,
                    "name"=>$name
                ]);
            }
        }
        $this->command->info('countries has been imported..');
        fclose($file);
    }

    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        // Seed Core Data
        $this->coreSeed();
        $this->command->info('Default Core data added.');

        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        UserGender::createDefault();
        UserMaritalStatus::createDefault();
        UserBloodType::createDefault();

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is admin and user? [y|N]', true)) {

            // Explode roles
            $roles_array = ["Admin","Manager","Director","Supervisor","Staff"];

            // add roles
            foreach($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if( $role->name == 'Admin' ) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } else {
                    // for others by default only read access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }

                // create one user for each role
                $this->createUser($role);
            }

            $this->command->info('Roles ' . implode(",", $roles_array) . ' added successfully');

        } else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('Added only default user role.');
        }
        // now lets seed some posts for demo
        Setting::CompanyProfileSeed();
        for($i = 1; $i < 50; $i++){
            $roleUser = Role::where("name","!=","Admin")->inRandomOrder()->first();
            $this->createUser($roleUser);
        }

        $division = Division::all();
        foreach($division as $d){
            $superior_id = User::inRandomOrder()->first()->id;
            $updated = Division::findOrFail($d->id);
            $updated->superior_id = $superior_id;
            $updated->save();
        }

        $this->command->warn('All done :)');
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
        $faker = Faker::create();
        $user = factory(User::class)->create();
        $user->assignRole($role->name);

        $gender_id = UserGender::inRandomOrder()->first()->id;
        $status_id = UserMaritalStatus::inRandomOrder()->first()->id;
        $blood_id =  UserBloodType::inRandomOrder()->first()->id;
        $identity_id = UserIdentityType::inRandomOrder()->first()->id;
        $bank_id = Bank::inRandomOrder()->first()->id;
        $country_id = Country::where("iso_code","ID")->first()->id;
        $regency = Regency::inRandomOrder()->first()->name;
        $job_id = Job::inRandomOrder()->first()->id;
        $type_id = EmployeeType::inRandomOrder()->first()->id;
        $position_id = Position::inRandomOrder()->first()->id;
        $division_id = Division::inRandomOrder()->first()->id;
       

        UserConfirm::Create([
            'user_id'=>$user->id,
            'token'=>base64_encode(strtolower($user->email.'.'.str_random(40)))
        ]);

        UserProfile::Create([
            'user_id'=>$user->id,
            'bank_id'=>$bank_id,
            'account_number'=>$faker->postcode,
            'identity_number'=>$faker->postcode,
            'tax_number'=>$faker->postcode,
            'medical_number'=>$faker->postcode,
            'nick_name'=>$faker->firstName,
            'first_name'=>$faker->firstName,
            'last_name'=>$faker->lastName,
            'birth_date'=>date('Y-m-d', strtotime("-".rand(20,50)." year")),
            'birth_place'=>$regency,
            'country_id'=> $country_id,
            'blood_id'=>$blood_id,
            'identity_id'=>$identity_id,
            'gender_id'=>$gender_id,
            'status_id'=>$status_id,
            'postal_code'=>$faker->postcode,
            'address'=>$faker->streetAddress,
            'about_me'=>$faker->paragraph
        ]);
        
        $current = Employee::where("position_id", $position_id)
            ->where("division_id", $division_id)
            ->where("join_date",">=",date("Y-01-01"))
            ->where("join_date","<=",date("Y-12-31"))
            ->count();

        $employee_number = array();
        $employee_number[] = date("y");
        $employee_number[] = \App\Helpers\AppHelper::indexToNumber($position_id, 4);
        $employee_number[] = \App\Helpers\AppHelper::indexToNumber($division_id, 4);
        $employee_number[] = \App\Helpers\AppHelper::indexToNumber((int)$current + 1, 4);

        Employee::create([
            "user_id"=>$user->id,
            "job_id"=>$job_id,
            "type_id"=>$type_id,
            "position_id"=>$position_id,
            "division_id"=>$division_id,
            "employee_number"=>implode(null, $employee_number),
            "join_date"=>now(),
            "is_banned"=>0,
            "is_blacklist"=>0,
        ]);

        $temp = User::find($user->id);
        $temp->access_groups = \App\Helpers\UserHelper::accessGroups([$role->id]);
        $temp->save();

        if($role->name == 'Admin' ) {
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "secret"');
        }
    }
}

<?php

namespace backend\controllers;

use common\models\KindWork2;
use common\models\ListPatients;
use common\models\Organization;
use Yii;
use common\models\LoadingPatient;
use yii\helpers\ArrayHelper;

/**
 * LoadingPatientController implements the CRUD actions for LoadingPatient model.
 */
class LoadingPatientController
{

    /**
     * Creates a new LoadingPatient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLoading()
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '5092M');
        $model = new LoadingPatient();
        $organization_title_item = ArrayHelper::map(Organization::find()->select(['id', 'title'])->all(), 'id', 'title');
        $loads = LoadingPatient::find()->orderby(['create_at' => SORT_DESC])->limit(10)->all();
        if (Yii::$app->request->post())
        {
            $post = Yii::$app->request->post()['LoadingPatient'];
            if ($_FILES)
            {
                $path = "list-patient-upl/"; //папака в которой лежит файл
                $extension = strtolower(substr(strrchr($_FILES['LoadingPatient']['name']['file'], '.'), 1));//узнали в каком формате файл пришел
                $file_name = $model->randomFileName($path, $extension); // сделали новое имя с проверкой есть ли такое имя в папке
                if (move_uploaded_file($_FILES['LoadingPatient']['tmp_name']['file'], $path . $file_name))
                { // переместили из временной папки, в которую изначально загрулся файл в новую директорию с новым именем
                    if (($file_list = fopen($path . $file_name, 'r')) !== false)
                    {//ищем файл в директории
                        $j = 0;
                        $out = [];
                        while (($data = fgetcsv($file_list, 50000, ";")))//читаем фйал в директории
                        {
                            for ($i = 0; $i < count($data); $i++)
                            {
                                $out[$j][$i] .= $data[$i];
                            }
                            $j++;
                        }
                        unset($out[0]);//удалил первую строку шапку таблицы
                        $out_save = array_values($out);

                        $array_p1 = [
                            'chemical_factor1',
                            'chemical_factor2',
                            'chemical_factor3',
                            'chemical_factor4',
                            'chemical_factor5',
                            'chemical_factor6',
                            'chemical_factor7',
                            'chemical_factor8',
                            'chemical_factor9',
                            'chemical_factor10',
                            'chemical_factor11',
                            'chemical_factor12',
                            'chemical_factor13',
                            'chemical_factor14',
                            'chemical_factor15',
                            'chemical_factor16',
                            'chemical_factor17',
                            'chemical_factor18',
                            'chemical_factor19',
                            'chemical_factor20',
                            'chemical_factor21',
                            'chemical_factor22',
                            'chemical_factor23',
                            'chemical_factor24',
                        ];
                        $array_p2 = [
                            'biological_factor1',
                            'biological_factor2',
                            'biological_factor3',
                            'biological_factor4',
                            'biological_factor5',
                            'biological_factor6',
                            'biological_factor7',
                            'biological_factor8',
                            'biological_factor9',
                            'biological_factor10',
                            'biological_factor11',
                            'biological_factor12',
                            'biological_factor13',
                            'biological_factor14',
                            'biological_factor15',
                            'biological_factor16',
                            'biological_factor17',
                            'biological_factor18',
                        ];
                        $array_p3 = [
                            'aerosols1',
                            'aerosols2',
                            'aerosols3',
                            'aerosols4',
                            'aerosols5',
                            'aerosols6',
                            'aerosols7',
                            'aerosols8',
                            'aerosols9',
                            'aerosols10',
                            'aerosols11',
                            'aerosols12',
                            'aerosols13',
                            'aerosols14',
                            'aerosols15',
                            'aerosols16',
                            'aerosols17',
                            'aerosols18',
                        ];
                        $array_p4 = [
                            'physical_factor1',
                            'physical_factor2',
                            'physical_factor3',
                            'physical_factor4',
                            'physical_factor5',
                            'physical_factor6',
                            'physical_factor7',
                            'physical_factor8',
                            'physical_factor9',
                            'physical_factor10',
                            'physical_factor11',
                            'physical_factor12',
                            'physical_factor13',
                            'physical_factor14',
                            'physical_factor15',
                            'physical_factor16',
                            'physical_factor17',
                            'physical_factor18',
                        ];
                        $array_p5 = [
                            'hard_work1',
                            'hard_work2',
                            'hard_work3',
                            'hard_work4',
                            'hard_work5',
                            'hard_work6',
                        ];
                        $array_p6 = [
                            'type_work',
                            'gets_2_fields_1',
                            'gets_2_fields_2',
                            'gets_2_fields_3',
                            'gets_2_fields_4',
                            'gets_2_fields_5',
                            'gets_2_fields_6',
                            'gets_2_fields_7',
                            'gets_2_fields_8',
                            'gets_2_fields_9',
                            'gets_2_fields_10',
                            'gets_2_fields_11',
                        ];
                        $patient_id = [];
                        //print_r($out_save);
                        //print_r('<br>');
                        //print_r('<br>');
                        //print_r('<br>');

                        for ($i = 0; $i < count($out_save); $i++)
                        {
                            $str_p = preg_replace('/\s+/', '', $out_save[$i][12]); //12 столбец это строка с пунктами разделили их в массив
                            $str_p = explode("/", $str_p);//12 столбец это строка с пунктами разделили их в массив
                            $number_carte = $post['organization_id'].'ОМ'.'1/'.$i;

                            $p_1 = [];
                            $p_2 = [];
                            $p_3 = [];
                            $p_4 = [];
                            $p_5 = [];
                            $p_6 = [];
                            for ($v = 0; $v < count($str_p); $v++)
                            {
                                $str_num = strstr($str_p[$v], '.', true);//определяем куда что куда
                                if ($str_num == 1)
                                {
                                    $p_1[] = $str_p[$v];
                                }
                                elseif ($str_num == 2)
                                {
                                    $p_2[] = $str_p[$v];
                                }
                                elseif ($str_num == 3)
                                {
                                    $p_3[] = $str_p[$v];
                                }
                                elseif ($str_num == 4)
                                {
                                    $p_4[] = $str_p[$v];
                                }
                                elseif ($str_num == 5)
                                {
                                    $p_5[] = $str_p[$v];
                                }
                                else
                                {
                                    $p_6[] = $str_p[$v];
                                }
                            }

                            if($out_save[$i][1] != ''){
                                $modelListPatients = new ListPatients();
                                $modelListPatients->organization_id = $post['organization_id'];
                                $modelListPatients->fio = $out_save[$i][1];
                                $modelListPatients->type_patient = 1;
                                $modelListPatients->card_number = $number_carte;
                                $modelListPatients->date_birth = $out_save[$i][2];//Дата рождения
                                $modelListPatients->sex =($out_save[$i][3] == 1 || $out_save[$i][3] == 0) ? $out_save[$i][3] : 1;
                                $modelListPatients->snils = $out_save[$i][4];//СНИЛС
                                $modelListPatients->address_overall = $out_save[$i][5];//Город
                                $modelListPatients->street = $out_save[$i][6];//Улица
                                $modelListPatients->house = $out_save[$i][7];//Дом
                                $modelListPatients->flat = $out_save[$i][8];//Квартира
                                $modelListPatients->department = $out_save[$i][9];//Цех, участок
                                $modelListPatients->experience = $out_save[$i][10];//Стаж работы
                                $modelListPatients->post_profession = $out_save[$i][11];//Профессия
                                $modelListPatients->order_type = 1;
                                $modelListPatients->federal_district_id = 5;
                                $modelListPatients->region_id = 48;
                                $modelListPatients->municipality_id = 253;
                                //СОХРАНЕНИЕ ПУНКТОВ
                                if (!empty($p_1))
                                {
                                    for ($j = 0; $j < count($p_1); $j++)
                                    {//это определили поля в БД
                                        if (($check = KindWork2::find()->where(['unique_number' => $p_1[$j]])->one()) !== null)
                                        {
                                            $modelListPatients[$array_p1[$j]] = $check->id;
                                        }
                                    }
                                }
                                if (!empty($p_2))
                                {
                                    for ($k = 0; $k < count($p_2); $k++)
                                    {//это определили поля в БД
                                        if (($check = KindWork2::find()->where(['unique_number' => $p_2[$k]])->one()) !== null)
                                        {
                                            $modelListPatients[$array_p2[$k]] = $check->id;
                                        }
                                    }
                                }
                                if (!empty($p_3))
                                {
                                    for ($h = 0; $h < count($p_3); $h++)
                                    {//это определили поля в БД
                                        if (($check = KindWork2::find()->where(['unique_number' => $p_3[$h]])->one()) !== null)
                                        {
                                            $modelListPatients[$array_p3[$h]] = $check->id;
                                        }
                                    }
                                }
                                if (!empty($p_4))
                                {
                                    for ($b = 0; $b < count($p_4); $b++)
                                    {//это определили поля в БД
                                        if (($check = KindWork2::find()->where(['unique_number' => $p_4[$b]])->one()) !== null)
                                        {
                                            $modelListPatients[$array_p4[$b]] = $check->id;
                                        }
                                    }
                                }
                                if (!empty($p_5))
                                {
                                    for ($t = 0; $t < count($p_5); $t++)
                                    {//это определили поля в БД
                                        if (($check = KindWork2::find()->where(['unique_number' => $p_5[$t]])->one()) !== null)
                                        {
                                            $modelListPatients[$array_p5[$t]] = $check->id;
                                        }
                                    }
                                }
                                if (!empty($p_6))
                                {
                                    for ($u = 0; $u < count($p_6); $u++)
                                    {//это определили поля в БД
                                        if (($check = KindWork2::find()->where(['unique_number' => $p_6[$u]])->one()) !== null)
                                        {
                                            $modelListPatients[$array_p6[$u]] = $check->id;
                                        }
                                    }
                                }
                                if ($modelListPatients->save(false))
                                {
                                    $patient_id[] = $modelListPatients->id;
                                }
                                else
                                {
                                    ListPatients::deleteall(['in', 'id', $patient_id]); //удаляем всех загрузившихся пациентов если ошибка
                                    //print_r($patient_id);
                                }
                            }
                        }

                        $modelLoadingPatient = new LoadingPatient();
                        $modelLoadingPatient->user_id = Yii::$app->user->identity->id;
                        $modelLoadingPatient->organization_id = $post['organization_id'];
                        $modelLoadingPatient->file_name = $file_name;
                        $modelLoadingPatient->number_rows = count($out_save);
                        $modelLoadingPatient->save(false);
                        return $this->render('viev', [
                            'model' => new LoadingPatient(),
                            'organization_title_item' => $organization_title_item,
                        ]);
                    }
                    else
                    {
                        Yii::$app->session->setFlash('error', "Не удалось прочесть файл!");
                    }
                }
                else
                {
                    Yii::$app->session->setFlash('error', "Не удалось загрузить файл!");
                }
            }
            else
            {
                Yii::$app->session->setFlash('error', "Что то пошло не так!");
            }

        }
        return $this->render('create', [
            'model' => $model,
            'loads' => $loads,
            'organization_title_item' => $organization_title_item,
        ]);
    }
}

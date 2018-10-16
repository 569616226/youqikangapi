<?php

namespace App\Containers\Revision\UI\API\Transformers;

use App\Containers\Revision\Models\Revision;
use App\Ship\Parents\Transformers\Transformer;

class RevisionTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param Revision $entity
     *
     * @return array
     */
    public function transform(Revision $entity)
    {

        $revisionable_type = config('revision-container.revisionable_type');//系统模块
        $key = config('revision-container.key');//操作类型
        $revisionable = $entity->revisionable()->withTrashed()->find($entity->revisionable_id);

        if($revisionable_type == 'App\\Containers\\Invitation\\Models\\Invitation' ){

          if($entity->key == 'created_at'){

            $value = '分享了 ' . optional($revisionable)->report->name ?? '未知内容';

          }

        }elseif($revisionable_type == 'App\\Containers\\Message\\Models\\Message'){

          $value = '微信模板消息发送成功';

        }else{

          switch ($entity->key) {

            case 'created_at' :

              $value = '新建了' . optional($revisionable)->name ?? '未知内容';
              break;

            case 'deleted_at' :

              $value = '删除了' . optional($revisionable)->name ?? '未知内容';
              break;

            case 'is_frozen' :

              if ($entity->new_value && !$entity->old_value) {

                $value = '冻结了' . optional($revisionable)->name;

              } elseif (!$entity->new_value && $entity->old_value) {

                $value = '解冻了' . optional($revisionable)->name;

              }

              break;

            case 'login' :

              $value = optional($revisionable)->name . ' 登陆了平台';

              break;

            default :

              $old_value = $entity->old_value ? mb_substr($entity->old_value, 0, 50, 'utf-8') . '......' : '空';
              $new_value = $entity->new_value ? mb_substr($entity->new_value, 0, 50, 'utf-8') . '......' : '空';

              $value = $old_value . '  更新为  ' . $new_value;
              break;
          }

        }


        $user_name = optional($entity->user)->name ?? '系统';

        $key_text = array_key_exists($entity->key, $key) ? $key[$entity->key] : '更新';
        $response = [

            'object'            => 'Revision',
            'revisionable_type' => $revisionable_type[$entity->revisionable_type],
            'user_name'         => $user_name,
            'key'               => $key_text,
            'id'                => $entity->id,
            'value'             => $value,
            'created_at'        => $entity->created_at->toDateTimeString(),
            'updated_at'        => $entity->updated_at->toDateTimeString(),

        ];

        return $response;
    }
}

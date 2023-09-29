<?php

namespace App\Helpers;

class Organization
{
    protected $members;
    protected $hierarchy;

    public function setMembers($members) {
        $this->members = $members;
    }

    public function setHierarchy($hierarchy) {
        $this->hierarchy = $hierarchy;
    }

    public function getHierarchyData() {
        if (empty($this->members)) return [];
        return $this->getHierarchyUserChildren();
    }

    public function getHierarchyDataString() {
        return json_encode($this->getHierarchyData());
    }

    public function getMembersData() {
        if (empty($this->hierarchy)) return [];
        $this->members = [];
        $this->getMembers($this->hierarchy);
        return $this->members;
    }

    protected function getHierarchyUserChildren($user = null) {
        $children = [];
        foreach ($this->members as $member) {
            if ((!$user && !$this->findManager($member))
                || ($user && $user['google_id'] == $member['manager_id'])
            ) {
                $children[] = $this->getHierarchyUser($member);
            }
        }
        return $children;
    }

    protected function getHierarchyUser($user) {
        return [
            'id' => $user['google_id'],
            'name' => $user['given_name'].' '.$user['family_name'],
            'avatar' => $user['avatar'],
            'isAdmin' => !empty($user['is_admin']),
            'children' => $this->getHierarchyUserChildren($user),
        ];
    }

    protected function findManager($user) {
        if (empty($user['manager_id'])) return null;
        foreach ($this->members as $member) {
            if ($member['google_id'] == $user['manager_id']) return $member;
        }
        return null;
    }

    protected function getMembers($hierarchy, $manager_id = null) {
        if (empty($hierarchy['id']) || !is_numeric($hierarchy['id'])
            || (!empty($hierarchy['children']) && !is_array($hierarchy['children']))
        ) {
            return;
        }
        if (($id = $hierarchy['id']) != 1) {
            $this->members[] = [
                'google_id' => $id,
                'manager_id' => $manager_id != 1 ? $manager_id : null,
            ];
        }
        foreach ($hierarchy['children'] ?? [] as $child) {
            $this->getMembers($child, $id);
        }
    }
}

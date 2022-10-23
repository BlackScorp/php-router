<?php

class ProfileController
{
    public function __invoke(int $id, Request $request){
        return 'Profile ID:'.$id;
    }
}
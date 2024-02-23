<?php

class NvmeTemp extends Temperature
{
    
    public static function detect() : array
    {
        $cmd = "lsblk | grep '^nvme' | cut -d' ' -f1";
        exec($cmd, $output, $result_code);

        $res = [];
        foreach($output as $row) {
            $res [] = new self($row);
        }
        return $res;
    }


	static function getType() : string
	{
		return "NVME";
	}

}

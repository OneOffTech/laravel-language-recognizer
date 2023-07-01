<?php

// config for Oneofftech/LanguageRecognizer

return [

    'default' => env('LANGUAGE_RECOGNIZER_DRIVER', 'local'),

    'drivers' => [

        'local' => [
            
            /*
             | Specify the path to the application that perform
             | the language recognition
             |
             | The binary path must end with the linux executable file name
             */
            'path' => env('LANGUAGE_RECOGNIZER_LOCAL_BIN_PATH', './bin/language-recognizer'),
            // 'exclude' => ['cat','sot','kat','bcl','glg','lao','lit','umb','tsn','vec','nso','ban','bug','knc','kng','ibb','lug','ace','bam','tzm','ydd','kmb','lun','shn','war','dyu','wol','nds','mkd','vmw','zgh','ewe','khk','slv','ayr','bem','emk','bci','bum','epo','pam','tiv','tpi','ven','ssw','nyn','kbd','iii','yao','lav','quz','src','rup','sco','tso','rmy','men','fon','nhn','dip','kde','snn','kbp','tem','toi','est','snk','cjk','ada','aii','quy','rmn','bin','gaa','ndo'],
        ],

        'deepl' => [
            'host' => env('LANGUAGE_RECOGNIZER_DEEPL_HOST', 'https://api-free.deepl.com'),
            'key' => env('LANGUAGE_RECOGNIZER_DEEPL_KEY', null),
        ],

    ]
];

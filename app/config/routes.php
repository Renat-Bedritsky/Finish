<?php

return [
    '\/?' => 'Base/Get/1',
    '\/?([0-9]*)' => 'Base/Get/$2',
    '\?([a-z0-9=\&]*)' => 'Base/Get/1',
    '\/?([0-9])*\?([a-z0-9=\&]*)' => 'Base/Get/$2',
    'categories' => 'Categories/Get',
    'basket' => 'Basket/Get',
    'basket\/clear' => 'Basket/Clear',
    '(mobile|portable|appliances|other)\/?' => 'Category/Page/$2_1',
    '(mobile|portable|appliances|other)\/([0-9]*)' => 'Category/Page/$2_$3',
    '(mobile|portable|appliances|other)\/([0-9])*\?([a-z0-9=\&]*)' => 'Category/Page/$2_$3',
    'profile\/([a-zA-Zа-яА-ЯёЁ0-9]*)' => 'Profile/Data/$2',
    'detail\/([a-zA-Zа-яА-ЯёЁ0-9_-]*)' => 'Detail/Get/$2',
    'control\/([a-zA-Zа-яА-ЯёЁ0-9_-]*)' => 'Control/Get/$2',
    'autorization' => 'Autorization/Get',
    'logout' => 'Base/Exit',
    'registration' => 'Registration/Get',
    'order' => 'Order/Get',
    'add' => 'Add/Add',
    'orders' => 'Orders/Get'
];
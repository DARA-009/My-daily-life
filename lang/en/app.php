<?php

return [
    // App & Brand
    'name' => 'My Daily Life',
    'tagline' => 'Personal Life & Productivity Management System',

    // Navigation & Modules
    'modules' => [
        'dashboard' => 'Dashboard',
        'schedule'  => 'Daily Schedule',
        'tasks'     => 'Tasks',
        'work'      => 'Work Log',
        'expenses'  => 'Finances',
        'goals'     => 'Monthly Goals',
        'study'     => 'Study Sessions',
        'habits'    => 'Habit Tracker',
        'skills'    => 'Skill Development',
        'notes'     => 'Notes & Ideas',
        'reports'   => 'Reports & Analytics',
        'profile'   => 'My Profile',
        'settings'  => 'Settings',
    ],

    // Common Actions & States
    'actions' => [
        'add'       => 'Create New',
        'edit'      => 'Edit',
        'delete'    => 'Delete',
        'save'      => 'Save Changes',
        'cancel'    => 'Cancel',
        'filter'    => 'Filter',
        'search'    => 'Search...',
        'all'       => 'All',
        'close'     => 'Close',
        'toggle'    => 'Toggle Status',
        'export'    => 'Export Data (CSV)',
        'log'       => 'Log Entry',
        'view_all'  => 'View All',
    ],

    'status' => [
        'planned'     => 'Planned',
        'in_progress' => 'In Progress',
        'completed'   => 'Completed',
        'done'        => 'Done',
        'pending'     => 'Pending',
        'skipped'     => 'Skipped',
        'active'      => 'Active',
    ],

    'priority' => [
        'high'   => 'High Priority',
        'medium' => 'Medium',
        'low'    => 'Low',
    ],

    // Schedule Module
    'schedule' => [
        'title'        => 'Daily Schedule',
        'subtitle'     => 'Organize and track your daily timeline and routines',
        'add_activity' => 'New Activity',
        'time'         => 'Time Slot',
        'category'     => 'Category',
        'is_work'      => 'Work Related Activity',
        'empty'        => 'No activities scheduled for this date.',
    ],

    // Tasks Module
    'tasks' => [
        'title'        => 'Task Management',
        'subtitle'     => 'Track and prioritize tasks across personal, work, and study',
        'add_task'     => 'New Task',
        'due_date'     => 'Due Date',
        'kind'         => 'Kind',
        'kind_personal'=> 'Personal',
        'kind_work'    => 'Work',
        'kind_study'   => 'Study',
        'progress'     => 'Progress',
        'empty'        => 'No tasks found matching criteria.',
    ],

    // Work Module
    'work' => [
        'title'        => 'Work & Projects',
        'subtitle'     => 'Monitor deep work hours and professional deliverables',
        'hours_logged' => 'Total Hours Logged',
        'deliverables' => 'Work Deliverables',
        'activities'   => 'Work Timeline',
        'empty'        => 'No work activities recorded for this date.',
    ],

    // Expenses / Financial Module
    'expenses' => [
        'title'          => 'Income & Expenses',
        'subtitle'       => 'Dual-currency cash flow tracking in USD ($) and KHR (៛)',
        'add_txn'        => 'Record Transaction',
        'income'         => 'Total Income',
        'expense'        => 'Total Expenses',
        'balance'        => 'Net Cash Flow',
        'type'           => 'Transaction Type',
        'amount'         => 'Amount',
        'currency'       => 'Currency',
        'payment_method' => 'Payment Method',
        'cash'           => 'Cash',
        'bank'           => 'Bank Transfer',
        'card'           => 'Card',
        'mobile_wallet'  => 'Mobile Wallet (ABA/Bakong)',
        'other'          => 'Other',
        'date'           => 'Date',
        'desc'           => 'Description',
        'empty'          => 'No transactions recorded yet.',
    ],

    // Goals Module
    'goals' => [
        'title'        => 'Monthly Goals',
        'subtitle'     => 'Define, track, and accomplish your key monthly objectives',
        'add_goal'     => 'New Goal',
        'target_date'  => 'Target Deadline',
        'log_progress' => 'Log Progress',
        'completed'    => 'Completed Goals',
        'avg_progress' => 'Average Progress',
        'empty'        => 'No goals set for this month yet.',
    ],

    // Study Module
    'study' => [
        'title'        => 'Study & Learning',
        'subtitle'     => 'Log study sessions and analyze subject mastery time',
        'add_subject'  => 'New Subject',
        'log_session'  => 'Log Study Session',
        'total_hours'  => 'Total Study Time',
        'subjects'     => 'Enrolled Subjects',
        'sessions'     => 'Session History',
        'duration'     => 'Duration (mins)',
        'topic'        => 'Topic / Notes',
        'empty'        => 'No study subjects or sessions recorded yet.',
    ],

    // Habits Module
    'habits' => [
        'title'       => 'Daily Habits',
        'subtitle'    => 'Build consistent routines with 7-day visual check-ins and streaks',
        'add_habit'   => 'New Habit',
        'frequency'   => 'Frequency',
        'daily'       => 'Daily',
        'weekly'      => 'Weekly',
        'target_days' => 'Target Days / Week',
        'streak'      => 'Current Streak',
        'check_in'    => 'Check In',
        'empty'       => 'No habits configured yet.',
    ],

    // Skills Module
    'skills' => [
        'title'        => 'Skill Development',
        'subtitle'     => 'Track skill proficiencies (1-5) and deliberate practice hours',
        'add_skill'    => 'New Skill',
        'current_lvl'  => 'Current Level',
        'target_lvl'   => 'Target Level',
        'total_hours'  => 'Practice Hours',
        'log_practice' => 'Log Practice',
        'empty'        => 'No skills in tracker yet.',
    ],

    // Notes Module
    'notes' => [
        'title'        => 'Notes & Ideas',
        'subtitle'     => 'Quick capture ideas, meeting minutes, and personal drafts',
        'add_note'     => 'New Note',
        'pinned'       => 'Pinned Notes',
        'others'       => 'All Notes',
        'pin'          => 'Pin',
        'unpin'        => 'Unpin',
        'empty'        => 'No notes created yet.',
    ],

    // Reports Module
    'reports' => [
        'title'        => 'Analytics & Reports',
        'subtitle'     => 'Holistic insights into financial health, productivity, and habits',
        'cash_flow'    => '6-Month Cash Flow',
        'study_stats'  => 'Study Time by Subject',
        'task_stats'   => 'Task Completion Velocity',
    ],

    // Profile & Settings
    'profile' => [
        'title'       => 'User Profile',
        'subtitle'    => 'Manage personal information, demographics, and avatar',
        'name'        => 'Full Name',
        'email'       => 'Email Address',
        'bio'         => 'Biography',
        'gender'      => 'Gender',
        'male'        => 'Male',
        'female'      => 'Female',
        'other'       => 'Other',
        'birthdate'   => 'Date of Birth',
        'occupation'  => 'Occupation',
        'avatar'      => 'Profile Photo',
    ],

    'settings' => [
        'title'            => 'System Settings',
        'subtitle'         => 'Customize language preferences, default currency, and security',
        'language'         => 'Interface Language',
        'currency'         => 'Default Currency',
        'timezone'         => 'Timezone',
        'security'         => 'Security & Password',
        'current_password' => 'Current Password',
        'new_password'     => 'New Password',
        'confirm_password' => 'Confirm New Password',
    ],
];

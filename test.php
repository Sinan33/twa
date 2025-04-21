<?php
// Include database connection
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توازن البنيان | اختبار الشخصية</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <style>
        :root {
            /* Primary Colors */
            --primary: #54c8e8;
            --primary-dark: #083347;
            --primary-light: rgba(84, 200, 232, 0.153);
            --white: #ffffff;

            /* Secondary Colors */
            --secondary: #8ad7ed;
            --dark: #083347;
            --light: rgba(84, 200, 232, 0.05);
            --border: #e2e8f0;
            --text-primary: #083347;
            --text-secondary: #4a6e7d;
            --text-muted: #b2bec3;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #54c8e8;

            /* Category Colors (neutral to hide category type) */
            --cat-a: #54c8e8;
            --cat-b: #54c8e8;
            --cat-c: #54c8e8;
            --cat-d: #54c8e8;

            /* Category Backgrounds */
            --cat-a-bg: rgba(84, 200, 232, 0.1);
            --cat-b-bg: rgba(84, 200, 232, 0.1);
            --cat-c-bg: rgba(84, 200, 232, 0.1);
            --cat-d-bg: rgba(84, 200, 232, 0.1);

            /* Shadows */
            --shadow-xs: 0 1px 2px rgba(8, 51, 71, 0.05);
            --shadow-sm: 0 1px 3px rgba(8, 51, 71, 0.1);
            --shadow: 0 4px 6px rgba(8, 51, 71, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(8, 51, 71, 0.1), 0 4px 6px -2px rgba(8, 51, 71, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(8, 51, 71, 0.1), 0 10px 10px -5px rgba(8, 51, 71, 0.04);
            --shadow-inner: inset 0 2px 4px 0 rgba(8, 51, 71, 0.06);
            --shadow-outline: 0 0 0 3px rgba(84, 200, 232, 0.25);

            /* Border Radius */
            --radius-xs: 0.125rem;
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-2xl: 2rem;
            --radius-full: 9999px;

            /* Transitions */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            --easing-standard: cubic-bezier(0.4, 0, 0.2, 1);
            --easing-accelerate: cubic-bezier(0.4, 0, 1, 1);
            --easing-decelerate: cubic-bezier(0, 0, 0.2, 1);

            /* Typography */
            --font-main: 'Tajawal', sans-serif;

            /* Z-Index Layers */
            --z-background: -10;
            --z-normal: 1;
            --z-above: 10;
            --z-modal: 100;
            --z-toast: 200;
            --z-tooltip: 300;
            --z-overlay: 900;
        }

        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-main);
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            background-color: var(--white);
            color: var(--text-primary);
            line-height: 1.6;
            direction: rtl;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        a {
            text-decoration: none;
            color: var(--primary);
            transition: var(--transition);
        }

        a:hover {
            color: var(--dark);
        }

        /* Grid System */
        .container {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -1rem;
        }

        .col {
            flex: 1 1 0%;
            padding: 0 1rem;
        }

        /* Header - Modern & Clean */
        .site-header {
            background-color: var(--white);
            box-shadow: var(--shadow);
            padding: 1.5rem 0;
            text-align: center;
            position: relative;
            border-bottom: 4px solid var(--primary);
            z-index: var(--z-above);
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo {
            max-width: 150px;
            height: auto;
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 2rem 0;
            background-color: var(--primary-light);
            position: relative;
        }

        /* Card Styles */
        .card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
            margin-bottom: 2rem;
            border: 1px solid rgba(84, 200, 232, 0.2);
            transform: translateZ(0);
            backface-visibility: hidden;
            position: relative;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px) translateZ(0);
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .card-header::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -100%;
            left: -100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            opacity: 0.7;
        }

        .card-body {
            padding: 2rem;
        }

        .card-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            background-color: rgba(84, 200, 232, 0.05);
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .card-header h1,
        .card-header h2,
        .card-header h3,
        .card-header h4,
        .card-header h5,
        .card-header h6 {
            color: var(--white);
            margin-bottom: 0.5rem;
        }

        h1 {
            font-size: 2.5rem;
        }

        h2 {
            font-size: 2rem;
        }

        h3 {
            font-size: 1.75rem;
        }

        h4 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1.25rem;
        }

        h6 {
            font-size: 1rem;
        }

        p {
            margin-bottom: 1rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--dark);
            background-color: var(--white);
            background-clip: padding-box;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            transition: var(--transition);
            box-shadow: var(--shadow-inner);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: 0;
            box-shadow: var(--shadow-outline);
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-right: 2.5rem;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }

        /* Radio Group */
        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .radio-container {
            position: relative;
            flex: 1 1 0%;
            min-width: 120px;
        }

        .radio-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .radio-label {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 1rem;
            cursor: pointer;
            color: var(--text-secondary);
            font-weight: 500;
            background-color: var(--white);
            border: 2px solid var(--border);
            border-radius: var(--radius);
            transition: var(--transition);
            text-align: center;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .radio-label:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .radio-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-light), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .radio-input:checked+.radio-label::before {
            opacity: 1;
        }

        .radio-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }

        .radio-input:checked+.radio-label {
            border-color: var(--primary);
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
            box-shadow: 0 0 0 2px var(--primary);
        }

        .radio-input:checked+.radio-label .radio-icon {
            color: var(--primary);
            transform: scale(1.2);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 2px solid transparent;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: var(--radius);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
            z-index: -1;
        }

        .btn:hover::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }

            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .btn:focus {
            outline: 0;
            box-shadow: var(--shadow-outline);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 51, 71, 0.15);
        }

        .btn-outline-primary {
            background-color: transparent;
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 51, 71, 0.15);
        }

        .btn-secondary {
            background-color: var(--secondary);
            border-color: var(--secondary);
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 51, 71, 0.15);
        }

        .btn-danger {
            background-color: var(--danger);
            border-color: var(--danger);
            color: var(--white);
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.15);
        }

        .btn-success {
            background-color: var(--success);
            border-color: var(--success);
            color: var(--white);
        }

        .btn-success:hover {
            background-color: #27ae60;
            border-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.15);
        }

        .btn-icon {
            margin-left: 0.5rem;
        }

        .btn-block {
            display: flex;
            width: 100%;
        }

        .btn:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Progress Elements */
        .progress-container {
            margin: 2rem 0;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .progress-track {
            width: 100%;
            height: 0.75rem;
            background-color: var(--border);
            border-radius: var(--radius-full);
            overflow: hidden;
            box-shadow: var(--shadow-inner);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-full);
            transition: width 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.2) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.2) 75%,
                    transparent 75%,
                    transparent);
            background-size: 16px 16px;
            animation: progressAnimation 1s linear infinite;
        }

        @keyframes progressAnimation {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 16px 0;
            }
        }

        /* Steps */
        .steps {
            display: flex;
            justify-content: space-between;
            margin: 2rem 0;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--border), var(--border));
            transform: translateY(-50%);
            z-index: 0;
            border-radius: var(--radius-full);
        }

        .step {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .step-circle {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--white);
            border: 3px solid var(--border);
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-secondary);
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .step-text {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.875rem;
            text-align: center;
            transition: var(--transition);
        }

        .step.active .step-circle {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
            color: var(--white);
            box-shadow: 0 0 0 5px var(--primary-light), 0 8px 16px rgba(8, 51, 71, 0.2);
            transform: scale(1.1);
        }

        .step.active .step-text {
            color: var(--primary);
            font-weight: 600;
            transform: translateY(4px);
        }

        .step.completed .step-circle {
            background: linear-gradient(135deg, var(--success), #27ae60);
            border-color: var(--success);
            color: var(--white);
        }

        .step.completed .step-text {
            color: var(--success);
        }

        .step.completed::after {
            content: '';
            position: absolute;
            top: 3.5rem;
            left: 50%;
            width: 8px;
            height: 8px;
            background-color: var(--success);
            border-radius: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.2);
        }

        /* Questions Styling */
        .question-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .question-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            border: 2px solid var(--border);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transform: translateZ(0);
            backface-visibility: hidden;
            z-index: 1;
        }

        .question-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-light), transparent);
            opacity: 0;
            transition: var(--transition);
            z-index: -1;
        }

        .question-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px) translateZ(0);
            border-color: var(--primary);
        }

        .question-card:hover::before {
            opacity: 0.5;
        }

        .question-card.selected {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px) translateZ(0);
            border-color: var(--primary);
            background-color: var(--primary-light);
        }

        .question-card.selected::before {
            opacity: 1;
        }

        .question-card.a-category.selected,
        .question-card.b-category.selected,
        .question-card.c-category.selected,
        .question-card.d-category.selected {
            border-color: var(--primary);
            background-color: var(--primary-light);
        }

        .question-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .question-icon {
            width: 3rem;
            height: 3rem;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-light);
            color: var(--primary);
            font-size: 1.25rem;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .selected .question-icon {
            background-color: var(--primary);
            color: var(--white);
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(8, 51, 71, 0.15);
        }

        .a-category .question-icon,
        .b-category .question-icon,
        .c-category .question-icon,
        .d-category .question-icon {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .question-text {
            font-weight: 500;
            color: var(--dark);
            font-size: 1.1rem;
            flex: 1;
        }

        .selected .question-text {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .question-rating {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: scale(0) rotate(-90deg);
            box-shadow: 0 4px 8px rgba(8, 51, 71, 0.15);
            z-index: 2;
        }

        .question-card.selected .question-rating {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        .selected-badge {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-full);
            box-shadow: var(--shadow);
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: scale(0) rotate(90deg);
            z-index: 2;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
        }

        .question-card.selected .selected-badge {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        .question-card.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: var(--light);
            transform: none !important;
        }

        .question-card.disabled:hover {
            transform: none;
            box-shadow: var(--shadow);
            border-color: var(--border);
        }

        .question-card.previous-selection {
            border-left: 4px solid var(--primary);
            background-color: var(--primary-light);
            opacity: 0.8;
            cursor: default;
        }

        .question-card.previous-selection .question-rating {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        /* Selection Info */
        .selection-info {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .selection-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .selection-counter {
            font-weight: 700;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.35rem 1rem;
            border-radius: var(--radius-full);
            backdrop-filter: blur(4px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Results Chart */
        .result-chart {
            width: 100%;
            height: 300px;
            margin: 2rem 0;
            position: relative;
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .result-grid {
                grid-template-columns: 1fr;
            }
        }

        .result-item {
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            background-color: var(--white);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .result-item:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .result-item.a-result,
        .result-item.b-result,
        .result-item.c-result,
        .result-item.d-result {
            border-right: 4px solid var(--primary);
            position: relative;
            overflow: hidden;
        }

        .result-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-light), transparent 70%);
            opacity: 0;
            transition: var(--transition);
            z-index: 0;
        }

        .result-item:hover::before {
            opacity: 1;
        }

        .result-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .result-title-icon {
            width: 3rem;
            height: 3rem;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            background: linear-gradient(135deg, var(--primary-light), rgba(84, 200, 232, 0.3));
            color: var(--primary);
            box-shadow: 0 4px 8px rgba(8, 51, 71, 0.1);
        }

        .result-title-text {
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .result-score {
            font-size: 3rem;
            font-weight: 800;
            text-align: center;
            margin: 1rem 0;
            color: var(--primary);
            text-shadow: 0 2px 4px rgba(8, 51, 71, 0.1);
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }

        .result-item:hover .result-score {
            transform: scale(1.1);
        }

        .result-bar {
            height: 0.75rem;
            background-color: rgba(226, 232, 240, 0.5);
            border-radius: var(--radius-full);
            overflow: hidden;
            position: relative;
            box-shadow: var(--shadow-inner);
            z-index: 1;
        }

        .result-progress {
            height: 100%;
            border-radius: var(--radius-full);
            width: 0;
            transition: width 1.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            position: relative;
        }

        .result-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(255, 255, 255, 0.2) 20%,
                    rgba(255, 255, 255, 0.1) 40%,
                    transparent 60%);
            background-size: 200% 100%;
            animation: shine 2s infinite linear;
        }

        @keyframes shine {
            to {
                background-position: 200% 0;
            }
        }

        .result-description {
            margin-top: 1rem;
            color: var(--text-secondary);
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* Radar Chart */
        .radar-chart {
            width: 100%;
            max-width: 500px;
            margin: 3rem auto;
            position: relative;
            background-color: var(--white);
            padding: 2rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        .radar-chart::before {
            content: 'توازن';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 5rem;
            font-weight: 900;
            color: rgba(8, 51, 71, 0.03);
            z-index: 0;
            letter-spacing: 0.2rem;
        }

        .radar-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
        }

        .radar-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .radar-circle {
            position: absolute;
            border-radius: 50%;
            border: 1.5px dashed var(--border);
            transition: all 0.5s ease;
        }

        .radar-circle-1 {
            width: 25%;
            height: 25%;
            animation: pulseBg 5s infinite alternate;
        }

        .radar-circle-2 {
            width: 50%;
            height: 50%;
            animation: pulseBg 7s infinite alternate;
        }

        .radar-circle-3 {
            width: 75%;
            height: 75%;
            animation: pulseBg 9s infinite alternate;
        }

        .radar-circle-4 {
            width: 100%;
            height: 100%;
            animation: pulseBg 11s infinite alternate;
        }

        @keyframes pulseBg {

            0%,
            100% {
                border-color: rgba(84, 200, 232, 0.3);
            }

            50% {
                border-color: rgba(8, 51, 71, 0.2);
            }
        }

        .radar-axis {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50%;
            height: 1.5px;
            background-color: rgba(84, 200, 232, 0.3);
            transform-origin: left center;
        }

        .radar-axis-a {
            transform: rotate(0deg);
        }

        .radar-axis-b {
            transform: rotate(90deg);
        }

        .radar-axis-c {
            transform: rotate(180deg);
        }

        .radar-axis-d {
            transform: rotate(270deg);
        }

        .radar-label {
            position: absolute;
            font-weight: 700;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            background-color: var(--white);
            box-shadow: var(--shadow);
            z-index: 5;
            transition: all 0.5s ease;
        }

        .radar-label-a {
            top: 1%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            color: var(--primary);
        }

        .radar-label-b {
            right: 1%;
            top: 50%;
            transform: translateX(50%) translateY(-50%);
            color: var(--primary);
        }

        .radar-label-c {
            bottom: 1%;
            left: 50%;
            transform: translateX(-50%) translateY(50%);
            color: var(--primary);
        }

        .radar-label-d {
            left: 1%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
            color: var(--primary);
        }

        .radar-data {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            clip-path: polygon(50% 50%, 50% 50%, 50% 50%, 50% 50%);
            background: rgba(84, 200, 232, 0.2);
            border: 2px solid var(--primary);
            transition: all 1.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: 3;
        }

        .radar-data::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(84, 200, 232, 0.4), transparent);
            clip-path: inherit;
            z-index: -1;
        }

        .radar-dot {
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--white);
            border: 3px solid var(--primary);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: 4;
            box-shadow: 0 0 0 4px rgba(84, 200, 232, 0.2), 0 4px 8px rgba(8, 51, 71, 0.1);
        }

        .radar-dot::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 4px;
            height: 4px;
            background-color: var(--primary);
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        /* Dominant Profile */
        .dominant-profile {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .dominant-profile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 30%, rgba(84, 200, 232, 0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .dominant-profile-header {
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .dominant-profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 40%);
            z-index: 0;
        }

        .dominant-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--white);
            position: relative;
            z-index: 1;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .dominant-content {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .dominant-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dominant-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .dominant-body {
            padding: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .dominant-name {
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
            color: var(--primary-dark);
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 0.5rem 0;
        }

        .dominant-name::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            border-radius: var(--radius-full);
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            transform-origin: center;
            animation: expand 2s ease-out forwards;
        }

        @keyframes expand {
            0% {
                transform: scaleX(0);
            }

            100% {
                transform: scaleX(1);
            }
        }

        .dominant-description {
            color: var(--text-secondary);
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        /* Rating Badge - New */
        .stage-rating-badge {
            left: 50%;
            transform: translate(-50%, -50%);
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            box-shadow: 0 10px 30px rgba(8, 51, 71, 0.2);
            z-index: 10;
            animation: pulse 2s infinite;
        }

        .stage-rating-badge::before {
            content: '';
            position: absolute;
            width: 110%;
            height: 110%;
            border-radius: 50%;
            border: 2px dashed rgba(255, 255, 255, 0.5);
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Traits Section */
        .traits-section {
            background-color: var(--primary-light);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            margin: 2.5rem 0;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .traits-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 70% 20%, rgba(255, 255, 255, 0.4) 0%, transparent 50%);
            pointer-events: none;
        }

        .traits-title {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
        }

        .traits-title-icon {
            color: var(--primary);
            font-size: 1.75rem;
            animation: pulse 2s infinite;
        }

        .traits-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.25rem;
        }

        .trait-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.2rem;
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border-right: 3px solid var(--primary);
        }

        .trait-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-light), transparent 80%);
            opacity: 0;
            transition: var(--transition);
        }

        .trait-item:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--shadow-md);
        }

        .trait-item:hover::before {
            opacity: 1;
        }

        .trait-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            background-color: var(--primary-light);
            color: var(--primary);
            box-shadow: 0 4px 8px rgba(8, 51, 71, 0.1);
            transition: var(--transition);
        }

        .trait-item:hover .trait-icon {
            transform: scale(1.1);
            background-color: var(--primary);
            color: var(--white);
        }

        /* Modern Results Section */
        .results-modern {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: 0;
            margin-bottom: 3rem;
            overflow: hidden;
            position: relative;
        }

        .results-header-modern {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 2rem;
            position: relative;
            text-align: center;
        }

        .results-header-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.7;
        }

        .results-title-modern {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .results-subtitle-modern {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .results-body-modern {
            padding: 0;
        }

        .results-summary-modern {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 0;
        }

        .result-card-modern {
            padding: 2rem;
            background-color: var(--white);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            text-align: center;
            border-bottom: 1px solid var(--border);
            border-right: 1px solid var(--border);
        }

        .result-card-modern:hover {
            background-color: var(--primary-light);
            transform: translateY(-5px);
            z-index: 10;
            box-shadow: var(--shadow-lg);
        }

        .result-card-modern::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, var(--primary-light), transparent 80%);
            opacity: 0;
            transition: var(--transition);
            z-index: 0;
        }

        .result-card-modern:hover::before {
            opacity: 1;
        }

        .result-icon-modern {
            width: 4rem;
            height: 4rem;
            background-color: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }

        .result-card-modern:hover .result-icon-modern {
            background-color: var(--primary);
            color: var(--white);
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(8, 51, 71, 0.15);
        }

        .result-title-modern {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .result-score-modern {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }

        .result-card-modern:hover .result-score-modern {
            transform: scale(1.1);
            color: var(--primary-dark);
        }

        .result-score-modern::after {
            content: '%';
            font-size: 1.5rem;
            vertical-align: top;
            margin-right: 0.25rem;
            color: var(--text-secondary);
        }

        .result-bar-modern {
            height: 0.5rem;
            background-color: rgba(226, 232, 240, 0.5);
            border-radius: var(--radius-full);
            overflow: hidden;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .result-progress-modern {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-full);
            transition: width 1.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .result-desc-modern {
            color: var(--text-secondary);
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        /* Call to Action */
        .cta-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: var(--radius-lg);
            padding: 3rem;
            color: var(--white);
            box-shadow: var(--shadow-lg);
            margin: 3.5rem 0;
            position: relative;
            overflow: hidden;
            transform: translateZ(0);
        }

        .cta-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.1;
            pointer-events: none;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.15) 0%, transparent 5%),
                radial-gradient(circle at 50% 60%, rgba(255, 255, 255, 0.1) 0%, transparent 5%),
                radial-gradient(circle at 80% 40%, rgba(255, 255, 255, 0.15) 0%, transparent 5%);
            background-size: 80px 80px;
            animation: floatingBubbles 15s infinite linear;
        }

        @keyframes floatingBubbles {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 100% 100%;
            }
        }

        .cta-content {
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }

        .cta-description {
            font-size: 1.15rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.7;
            max-width: 80%;
        }

        .cta-price {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 1.5rem 0;
            display: inline-block;
            position: relative;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1.5rem;
            border-radius: var(--radius);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .cta-price-label {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-right: 0.5rem;
            font-weight: 500;
        }

        .cta-features {
            margin: 2.5rem 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: var(--radius);
            transition: var(--transition);
            backdrop-filter: blur(4px);
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .feature-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .cta-button {
            background-color: var(--white);
            color: var(--primary-dark);
            font-weight: 700;
            padding: 1.25rem 2.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
            font-size: 1.1rem;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    rgba(84, 200, 232, 0) 0%,
                    rgba(84, 200, 232, 0.1) 50%,
                    rgba(84, 200, 232, 0) 100%);
            transform: translateX(-100%);
            z-index: -1;
        }

        .cta-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .cta-button:hover::before {
            animation: shine 1.5s infinite;
        }

        /* Alerts */
        .alert {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            max-width: 350px;
            background-color: var(--white);
            border-radius: var(--radius);
            padding: 1.25rem;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform: translateX(calc(100% + 2rem));
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-right: 4px solid;
        }

        .alert.show {
            transform: translateX(0);
        }

        .alert-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 1.1rem;
        }

        .alert-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0.25rem;
            align-self: flex-start;
            transition: var(--transition);
        }

        .alert-close:hover {
            color: var(--dark);
            transform: rotate(90deg);
        }

        .alert-success {
            border-color: var(--success);
        }

        .alert-success .alert-icon {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--success);
        }

        .alert-error {
            border-color: var(--danger);
        }

        .alert-error .alert-icon {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger);
        }

        .alert-info {
            border-color: var(--info);
        }

        .alert-info .alert-icon {
            background-color: rgba(84, 200, 232, 0.1);
            color: var(--info);
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #085165a3;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
            backdrop-filter: blur(5px);
        }

        .loading-logo {
            margin-bottom: 2.5rem;
            animation: pulse 2s infinite;
        }

        .loading-logo img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 0 8px rgba(84, 200, 232, 0.2), 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .loading-text {
            color: var(--white);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 2.5rem;
            text-align: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid rgba(84, 200, 232, 0.3);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        /* Modal/Popup Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(8, 51, 71, 0.85);
            z-index: 9000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: var(--shadow-lg);
            transform: translateY(50px) scale(0.95);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .modal-overlay.show .modal {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 1.5rem 2rem;
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            opacity: 0.6;
        }

        .modal-title {
            font-weight: 800;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .modal-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.25rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 1;
        }

        .modal-close:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem;
            color: var(--text-primary);
        }

        .modal-steps {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .modal-step {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background-color: var(--primary-light);
            border-radius: var(--radius);
            position: relative;
            transition: var(--transition);
        }

        .modal-step:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .modal-step-number {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(8, 51, 71, 0.15);
        }

        .modal-step-content {
            flex: 1;
        }

        .modal-step-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--primary-dark);
        }

        .modal-step-desc {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .modal-rating-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .modal-rating-table th,
        .modal-rating-table td {
            padding: 1rem;
            text-align: center;
            border: 1px solid var(--border);
        }

        .modal-rating-table th {
            background-color: var(--primary);
            color: var(--white);
            font-weight: 700;
        }

        .modal-rating-table td {
            background-color: var(--white);
        }

        .modal-rating-table tr:hover td {
            background-color: var(--primary-light);
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: flex-end;
            border-top: 1px solid var(--border);
            background-color: rgba(84, 200, 232, 0.05);
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }

        /* Animations */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Results Section */
        .results-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .results-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            border-radius: var(--radius-full);
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
        }

        .results-summary {
            display: flex;
            align-items: stretch;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .results-card {
            background-color: var(--white);
            padding: 2rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            text-align: center;
            position: relative;
            overflow: hidden;
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-top: 4px solid var(--primary);
        }

        .results-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-light), transparent 70%);
            opacity: 0;
            transition: var(--transition);
            z-index: 0;
        }

        .results-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .results-card:hover::before {
            opacity: 1;
        }

        .results-card-header {
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .results-card-icon {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), rgba(84, 200, 232, 0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary);
            margin: 0 auto 1rem;
            transition: var(--transition);
        }

        .results-card:hover .results-card-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            box-shadow: 0 8px 16px rgba(8, 51, 71, 0.15);
        }

        .results-card-body {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .results-score {
            font-size: 4rem;
            font-weight: 800;
            color: var(--primary);
            text-shadow: 0 2px 4px rgba(8, 51, 71, 0.1);
            margin: 1rem 0;
            transition: var(--transition);
            position: relative;
            display: inline-block;
        }

        .results-score::after {
            content: '%';
            position: absolute;
            top: 0.5rem;
            right: -1.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .results-card:hover .results-score {
            transform: scale(1.1);
        }

        .results-description {
            color: var(--text-secondary);
            margin-top: 1rem;
            line-height: 1.6;
        }

        /* Enhanced 3D Radar Chart */
        .radar-chart-3d {
            position: relative;
            perspective: 1000px;
            transform-style: preserve-3d;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .radar-container-3d {
            transform: rotateX(30deg);
            transition: all 0.8s ease;
        }

        .radar-chart:hover .radar-container-3d {
            transform: rotateX(40deg) rotateZ(10deg);
        }

        .radar-circle-3d {
            box-shadow: 0 4px 20px rgba(8, 51, 71, 0.1);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .radar-data-3d {
            box-shadow: 0 10px 30px rgba(8, 51, 71, 0.15);
        }

        /* Interactive Traits Section */
        .traits-interactive {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .trait-card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .trait-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .trait-card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .trait-card-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .trait-card-body {
            padding: 1.5rem;
        }

        .trait-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary-dark);
        }

        .trait-list-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .trait-list-item:last-child {
            border-bottom: none;
        }

        .trait-list-icon {
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* Animation utility classes */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        .animate-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-15px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        /* Prism effect for header */
        .prism-header {
            position: relative;
            overflow: hidden;
        }

        .prism-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.1) 50%,
                    rgba(255, 255, 255, 0) 100%);
            transform: rotate(25deg);
            animation: prismShift 6s linear infinite;
        }

        @keyframes prismShift {
            0% {
                transform: rotate(25deg) translateX(-30%);
            }

            100% {
                transform: rotate(25deg) translateX(30%);
            }
        }

        /* Particle background for results */
        .particle-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: rgba(84, 200, 232, 0.15);
            pointer-events: none;
            animation: float 8s infinite;
        }

        /* Confetti */
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            opacity: 0.8;
        }

        /* Responsive Utilities */
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        .slide-up {
            animation: slideUp 0.5s ease forwards;
        }

        .fade-out {
            animation: fadeOut 0.5s ease forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        /* Spacing utilities */
        .mt-1 {
            margin-top: 0.5rem;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .mb-1 {
            margin-bottom: 0.5rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .mb-4 {
            margin-bottom: 2rem;
        }

        .mb-5 {
            margin-bottom: 3rem;
        }

        /* Flex & Alignment utilities */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .d-flex {
            display: flex;
        }

        .align-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-center {
            justify-content: center;
        }

        .flex-column {
            flex-direction: column;
        }

        .gap-1 {
            gap: 0.5rem;
        }

        .gap-2 {
            gap: 1rem;
        }

        .gap-3 {
            gap: 1.5rem;
        }

        /* Animate.css compatibility classes */
        .animate__animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .animate__fadeIn {
            animation-name: fadeIn;
        }

        .animate__fadeOut {
            animation-name: fadeOut;
        }

        .animate__fadeOutRight {
            animation-name: fadeOutRight;
        }

        .animate__fadeOutLeft {
            animation-name: fadeOutLeft;
        }

        .animate__fadeInLeft {
            animation-name: fadeInLeft;
        }

        .animate__fadeInRight {
            animation-name: fadeInRight;
        }

        .animate__pulse {
            animation-name: pulse;
        }

        .animate__headShake {
            animation-name: headShake;
        }

        .animate__rubberBand {
            animation-name: rubberBand;
        }

        .animate__heartBeat {
            animation-name: heartBeat;
        }

        .animate__bounceInRight {
            animation-name: bounceInRight;
        }

        .animate__bounceOutRight {
            animation-name: bounceOutRight;
        }

        .animate__delay-1s {
            animation-delay: 1s;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translate3d(-100%, 0, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translate3d(100%, 0, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeOutLeft {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translate3d(-100%, 0, 0);
            }
        }

        @keyframes fadeOutRight {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translate3d(100%, 0, 0);
            }
        }

        @keyframes headShake {
            0% {
                transform: translateX(0);
            }

            6.5% {
                transform: translateX(-6px) rotateY(-9deg);
            }

            18.5% {
                transform: translateX(5px) rotateY(7deg);
            }

            31.5% {
                transform: translateX(-3px) rotateY(-5deg);
            }

            43.5% {
                transform: translateX(2px) rotateY(3deg);
            }

            50% {
                transform: translateX(0);
            }
        }

        @keyframes rubberBand {
            0% {
                transform: scale3d(1, 1, 1);
            }

            30% {
                transform: scale3d(1.25, 0.75, 1);
            }

            40% {
                transform: scale3d(0.75, 1.25, 1);
            }

            50% {
                transform: scale3d(1.15, 0.85, 1);
            }

            65% {
                transform: scale3d(0.95, 1.05, 1);
            }

            75% {
                transform: scale3d(1.05, 0.95, 1);
            }

            100% {
                transform: scale3d(1, 1, 1);
            }
        }

        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            14% {
                transform: scale(1.3);
            }

            28% {
                transform: scale(1);
            }

            42% {
                transform: scale(1.3);
            }

            70% {
                transform: scale(1);
            }
        }

        @keyframes bounceInRight {

            from,
            60%,
            75%,
            90%,
            to {
                animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
            }

            from {
                opacity: 0;
                transform: translate3d(3000px, 0, 0) scaleX(3);
            }

            60% {
                opacity: 1;
                transform: translate3d(-25px, 0, 0) scaleX(1);
            }

            75% {
                transform: translate3d(10px, 0, 0) scaleX(0.98);
            }

            90% {
                transform: translate3d(-5px, 0, 0) scaleX(0.995);
            }

            to {
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes bounceOutRight {
            20% {
                opacity: 1;
                transform: translate3d(-20px, 0, 0) scaleX(0.9);
            }

            to {
                opacity: 0;
                transform: translate3d(2000px, 0, 0) scaleX(2);
            }
        }

        /* Media Queries */
        @media (max-width: 1024px) {
            .result-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .cta-features {
                grid-template-columns: 1fr;
            }

            .cta-description {
                max-width: 100%;
            }

            .cta-card {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.75rem;
            }

            .question-list {
                grid-template-columns: 1fr;
            }

            .steps {
                overflow-x: auto;
                padding-bottom: 1rem;
            }

            .step-text {
                display: none;
            }

            .card-footer {
                flex-direction: column;
            }

            .btn-block {
                width: 100%;
            }

            .traits-list {
                grid-template-columns: 1fr;
            }

            .results-summary {
                flex-direction: column;
                align-items: center;
            }

            .results-card {
                width: 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 1rem;
            }

            .card-body,
            .card-header,
            .card-footer {
                padding: 1.25rem;
            }

            .btn {
                padding: 0.625rem 1.25rem;
            }

            .selection-info {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .radio-group {
                flex-direction: column;
            }

            .dominant-profile-header {
                flex-direction: column;
                text-align: center;
            }

            .cta-title {
                font-size: 1.5rem;
            }

            .cta-price {
                font-size: 2.5rem;
            }

            .traits-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-logo">
            <img src="log.png" alt="Logo" class="logo">
        </div>
        <div class="loading-text" id="loadingText">جاري تحميل اختبار توازن للشخصية</div>
        <div class="spinner"></div>
    </div>

    <!-- Instruction Modal -->
    <div class="modal-overlay" id="instructionModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">كيفية إجراء اختبار توازن</h2>
                <p class="modal-subtitle">شرح تفصيلي لآلية الاختبار ومراحله</p>
                <button class="modal-close" id="closeInstructionModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-3">اختبار توازن للشخصية يتكون من ٢٠ صفة موزعة على خمس مراحل. في كل مرحلة عليك اختيار ٤ صفات فقط حسب مدى انطباقها عليك.</p>

                <div class="modal-steps">
                    <div class="modal-step">
                        <div class="modal-step-number">١</div>
                        <div class="modal-step-content">
                            <div class="modal-step-title">اقرأ العبارات كاملة بتركيز</div>
                            <div class="modal-step-desc">في البداية، اقرأ جميع الـ ٢٠ عبارة بشكل كامل وتعرف على محتواها قبل البدء بالاختيار.</div>
                        </div>
                    </div>

                    <div class="modal-step">
                        <div class="modal-step-number">٢</div>
                        <div class="modal-step-content">
                            <div class="modal-step-title">اختر في كل مرحلة ٤ صفات فقط</div>
                            <div class="modal-step-desc">في كل مرحلة من المراحل الخمس، ستختار ٤ صفات حسب درجة انطباقها عليك وفقاً للمقياس التالي:</div>
                        </div>
                    </div>
                </div>

                <table class="modal-rating-table">
                    <thead>
                        <tr>
                            <th>المرحلة</th>
                            <th>الدرجة</th>
                            <th>مدى الانطباق</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>الأولى</td>
                            <td>٥</td>
                            <td>تنطبق عليك بشكل كبير جداً</td>
                        </tr>
                        <tr>
                            <td>الثانية</td>
                            <td>٤</td>
                            <td>تنطبق عليك بشكل كبير</td>
                        </tr>
                        <tr>
                            <td>الثالثة</td>
                            <td>٣</td>
                            <td>تنطبق عليك بشكل متوسط</td>
                        </tr>
                        <tr>
                            <td>الرابعة</td>
                            <td>٢</td>
                            <td>تنطبق عليك بشكل ضعيف</td>
                        </tr>
                        <tr>
                            <td>الخامسة</td>
                            <td>١</td>
                            <td>لا تنطبق عليك أبداً</td>
                        </tr>
                    </tbody>
                </table>

                <div class="modal-steps">
                    <div class="modal-step">
                        <div class="modal-step-number">٣</div>
                        <div class="modal-step-content">
                            <div class="modal-step-title">الانتقال بين المراحل</div>
                            <div class="modal-step-desc">بعد اختيار ٤ صفات في كل مرحلة، انتقل للمرحلة التالية باستخدام زر "التالي". يمكنك أيضاً العودة إلى المراحل السابقة لتعديل اختياراتك.</div>
                        </div>
                    </div>

                    <div class="modal-step">
                        <div class="modal-step-number">٤</div>
                        <div class="modal-step-content">
                            <div class="modal-step-title">عرض النتائج</div>
                            <div class="modal-step-desc">بعد الانتهاء من جميع المراحل، سيتم تحليل إجاباتك وعرض نتائج اختبار الشخصية بتفاصيلها المختلفة.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="startTestFromModal">
                    <i class="fas fa-check btn-icon"></i>
                    فهمت، هيا نبدأ
                </button>
            </div>
        </div>
    </div>

    <!-- Simplified Header with only logo -->
    <header class="site-header">
        <div class="logo-container">
            <img src="log.png" alt="Logo" class="logo">
        </div>
    </header>

    <main>
        <div class="container">
            <!-- Registration Form -->
            <div id="registrationForm" class="card fade-in">
                <div class="card-header prism-header">
                    <h1 class="text-center">اختبار توازن للشخصية</h1>
                    <p class="text-center">اكتشف نمط شخصيتك وفهم طريقة تفكيرك وتحليل نقاط قوتك</p>
                </div>

                <div class="card-body">
                    <form id="userForm" class="slide-up">
                        <div class="form-group">
                            <label class="form-label" for="fullName">الاسم الكامل</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="fullName" placeholder="أدخل اسمك الكامل" required>
                                <i class="fas fa-user input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="phone">رقم الهاتف</label>
                            <div class="input-group">
                                <input type="tel" class="form-control" id="phone" placeholder="أدخل رقم هاتفك" required>
                                <i class="fas fa-phone-alt input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">البريد الإلكتروني</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" placeholder="أدخل بريدك الإلكتروني" required>
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">الجنس</label>
                            <div class="radio-group">
                                <div class="radio-container">
                                    <input class="radio-input" type="radio" name="gender" id="male" value="male" checked>
                                    <label class="radio-label" for="male">
                                        <i class="fas fa-mars radio-icon"></i>
                                        ذكر
                                    </label>
                                </div>
                                <div class="radio-container">
                                    <input class="radio-input" type="radio" name="gender" id="female" value="female">
                                    <label class="radio-label" for="female">
                                        <i class="fas fa-venus radio-icon"></i>
                                        أنثى
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="startTestBtn" class="btn btn-primary btn-block mt-4">
                            <i class="fas fa-arrow-left btn-icon"></i>
                            ابدأ الاختبار
                        </button>
                    </form>
                </div>
            </div>

            <!-- Test Container -->
            <div id="testContainer" class="card fade-in" style="display: none;">
                <div class="card-header prism-header">
                    <h2>اختبار توازن للشخصية</h2>
                    <p>في كل مرحلة، اختر ٤ عبارات فقط التي تنطبق عليك حسب درجة المرحلة</p>
                </div>

                <div class="card-body">
                    <div class="progress-container">
                        <div class="progress-label">
                            <span>تقدمك في الاختبار</span>
                            <span id="progressText">0%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="steps">
                        <div class="step active" data-step="1">
                            <div class="step-circle"><i class="fas fa-check-circle"></i></div>
                            <div class="step-text">المرحلة الأولى</div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-circle"><i class="fas fa-check-circle"></i></div>
                            <div class="step-text">المرحلة الثانية</div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-circle"><i class="fas fa-check-circle"></i></div>
                            <div class="step-text">المرحلة الثالثة</div>
                        </div>
                        <div class="step" data-step="4">
                            <div class="step-circle"><i class="fas fa-check-circle"></i></div>
                            <div class="step-text">المرحلة الرابعة</div>
                        </div>
                        <div class="step" data-step="5">
                            <div class="step-circle"><i class="fas fa-check-circle"></i></div>
                            <div class="step-text">المرحلة الخامسة</div>
                        </div>
                    </div>

                    <!-- Section 1 -->
                    <div class="test-section" id="section1">
                        <div class="selection-info">
                            <div>المرحلة الأولى: اختر ٤ عبارات تنطبق عليك بشكل كبير جداً</div>
                            <div class="selection-counter" id="counter1">0/4</div>
                        </div>
                        <!-- Large rating badge -->
                        <div class="stage-rating-badge">5</div>
                        <h4 style="margin-top: 10px;">اختر العبارات التي تنطبق عليك بشكل كبير جدا</h4>

                        <div class="question-list" id="questionList1"></div>
                    </div>

                    <!-- Section 2 -->
                    <div class="test-section" id="section2" style="display: none;">
                        <div class="selection-info">
                            <div>المرحلة الثانية: اختر ٤ عبارات تنطبق عليك بشكل كبير</div>
                            <div class="selection-counter" id="counter2">0/4</div>
                        </div>

                        <!-- Large rating badge -->
                        <div class="stage-rating-badge">4</div>
                        <h4 style="margin-top: 10px;">اختر العبارات التي تنطبق عليك بشكل كبير</h4>

                        <div class="question-list" id="questionList2"></div>
                    </div>

                    <!-- Section 3 -->
                    <div class="test-section" id="section3" style="display: none;">
                        <div class="selection-info">
                            <div>المرحلة الثالثة: اختر ٤ عبارات تنطبق عليك بشكل متوسط</div>
                            <div class="selection-counter" id="counter3">0/4</div>
                        </div>

                        <!-- Large rating badge -->
                        <div class="stage-rating-badge">3</div>
                        <h4 style="margin-top: 10px;">اختر العبارات التي تنطبق عليك بشكل متوسط</h4>

                        <div class="question-list" id="questionList3"></div>
                    </div>

                    <!-- Section 4 -->
                    <div class="test-section" id="section4" style="display: none;">
                        <div class="selection-info">
                            <div>المرحلة الرابعة: اختر ٤ عبارات تنطبق عليك بشكل ضعيف</div>
                            <div class="selection-counter" id="counter4">0/4</div>
                        </div>

                        <!-- Large rating badge -->
                        <div class="stage-rating-badge">2</div>
                        <h4 style="margin-top: 10px;">اختر العبارات التي تنطبق بشكل ضعيف</h4>

                        <div class="question-list" id="questionList4"></div>
                    </div>

                    <!-- Section 5 (New) -->
                    <div class="test-section" id="section5" style="display: none;">
                        <div class="selection-info">
                            <div>المرحلة الخامسة: اختر ٤ عبارات لا تنطبق عليك أبداً</div>
                            <div class="selection-counter" id="counter5">0/4</div>
                        </div>

                        <!-- Large rating badge -->
                        <div class="stage-rating-badge">1</div>
                        <h4 style="margin-top: 10px;">اختر العبارات التي لا تنطبق عليك أبدا</h4>

                        <div class="question-list" id="questionList5"></div>
                    </div>
                </div>

                <div class="card-footer">
                    <button id="prevBtn" class="btn btn-outline-primary" style="display: none;">
                        <i class="fas fa-arrow-right btn-icon"></i>
                        السابق
                    </button>
                    <button id="nextBtn" class="btn btn-primary">
                        <i class="fas fa-arrow-left btn-icon"></i>
                        التالي
                    </button>
                    <button id="submitBtn" class="btn btn-success" style="display: none;">
                        <i class="fas fa-check btn-icon"></i>
                        إنهاء الاختبار وعرض النتائج
                    </button>
                </div>
            </div>

            <!-- Results Container - Redesigned, Modern Version -->
            <div id="resultsContainer" style="display: none;">
                <!-- Modern Results Card -->
                <div class="results-modern">
                    <div class="results-header-modern">
                        <h2 class="results-title-modern">نتائج اختبار توازن للشخصية</h2>
                        <p class="results-subtitle-modern">تعرّف على نمط شخصيتك الفريد وخصائصك المميزة</p>
                    </div>

                    <div class="results-body-modern">
                        <div class="results-summary-modern">
                            <!-- Result Card A -->
                            <div class="result-card-modern" data-aos="fade-up" data-aos-delay="100">
                                <div class="result-icon-modern">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <h3 class="result-title-modern">المنطقي التحليلي</h3>
                                <div class="result-score-modern" id="scoreA">0</div>
                                <div class="result-bar-modern">
                                    <div class="result-progress-modern" id="progressA" style="width: 0%"></div>
                                </div>
                                <p class="result-desc-modern">
                                    التفكير المنطقي التحليلي، يعتمد على الحقائق والبيانات في اتخاذ القرارات
                                </p>
                            </div>

                            <!-- Result Card B -->
                            <div class="result-card-modern" data-aos="fade-up" data-aos-delay="200">
                                <div class="result-icon-modern">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <h3 class="result-title-modern">المنظم التنفيذي</h3>
                                <div class="result-score-modern" id="scoreB">0</div>
                                <div class="result-bar-modern">
                                    <div class="result-progress-modern" id="progressB" style="width: 0%"></div>
                                </div>
                                <p class="result-desc-modern">
                                    التفكير المنظم التنفيذي، يهتم بالتفاصيل والإجراءات المنهجية
                                </p>
                            </div>

                            <!-- Result Card C -->
                            <div class="result-card-modern" data-aos="fade-up" data-aos-delay="300">
                                <div class="result-icon-modern">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h3 class="result-title-modern">العاطفي الاجتماعي</h3>
                                <div class="result-score-modern" id="scoreC">0</div>
                                <div class="result-bar-modern">
                                    <div class="result-progress-modern" id="progressC" style="width: 0%"></div>
                                </div>
                                <p class="result-desc-modern">
                                    التفكير العاطفي الاجتماعي، يهتم بالعلاقات والتواصل الإنساني
                                </p>
                            </div>

                            <!-- Result Card D -->
                            <div class="result-card-modern" data-aos="fade-up" data-aos-delay="400">
                                <div class="result-icon-modern">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <h3 class="result-title-modern">الابتكاري الاستراتيجي</h3>
                                <div class="result-score-modern" id="scoreD">0</div>
                                <div class="result-bar-modern">
                                    <div class="result-progress-modern" id="progressD" style="width: 0%"></div>
                                </div>
                                <p class="result-desc-modern">
                                    التفكير الابتكاري الاستراتيجي، يهتم بالرؤية المستقبلية والأفكار الجديدة
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced 3D Radar Chart -->
                <div class="radar-chart" data-aos="zoom-in">
                    <div class="radar-chart-3d">
                        <div class="radar-container radar-container-3d">
                            <div class="radar-bg">
                                <div class="radar-circle radar-circle-1 radar-circle-3d"></div>
                                <div class="radar-circle radar-circle-2 radar-circle-3d"></div>
                                <div class="radar-circle radar-circle-3 radar-circle-3d"></div>
                                <div class="radar-circle radar-circle-4 radar-circle-3d"></div>
                                <div class="radar-axis radar-axis-a"></div>
                                <div class="radar-axis radar-axis-b"></div>
                                <div class="radar-axis radar-axis-c"></div>
                                <div class="radar-axis radar-axis-d"></div>
                            </div>
                            <div class="radar-label radar-label-a animate-float">A</div>
                            <div class="radar-label radar-label-b animate-float">B</div>
                            <div class="radar-label radar-label-c animate-float">C</div>
                            <div class="radar-label radar-label-d animate-float">D</div>
                            <div class="radar-data radar-data-3d" id="radarData"></div>
                            <div class="radar-dot" id="radarDotA" style="top: 50%; left: 50%"></div>
                            <div class="radar-dot" id="radarDotB" style="top: 50%; left: 50%"></div>
                            <div class="radar-dot" id="radarDotC" style="top: 50%; left: 50%"></div>
                            <div class="radar-dot" id="radarDotD" style="top: 50%; left: 50%"></div>
                        </div>
                    </div>
                    <div class="particle-bg" id="particleBg"></div>
                </div>

                <!-- Dominant Profile -->
                <div id="dominantProfile" class="dominant-profile"></div>

                <!-- Traits List -->
                <div class="traits-section" data-aos="fade-up">
                    <div class="traits-title">
                        <i class="fas fa-star traits-title-icon"></i>
                        <h3>سمات شخصيتك البارزة</h3>
                    </div>
                    <div class="traits-interactive" id="traitsList"></div>
                </div>

                <!-- Call to Action -->
                <div class="cta-card" data-aos="fade-up">
                    <div class="cta-pattern"></div>
                    <div class="cta-content">
                        <h3 class="cta-title">احصل على استشارة متخصصة مع خبير في تحليل الشخصيات</h3>
                        <p class="cta-description">تواصل مع خبرائنا المتخصصين في علم النفس وتحليل الشخصية للحصول على فهم أعمق لشخصيتك وكيفية الاستفادة منها في حياتك المهنية والشخصية.</p>

                        <div>
                            <span class="cta-price-label">فقط</span>
                            <span class="cta-price">400 ريال</span>
                        </div>

                        <div class="cta-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span>جلسة استشارية مخصصة لمدة ساعة مع خبير معتمد</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <span>تحليل مفصل لنقاط القوة والضعف في شخصيتك</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <span>خطة تطويرية مخصصة لتعزيز مهاراتك</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span>تقرير شامل بنتائج التحليل والتوصيات</span>
                            </div>
                        </div>

                        <button id="consultationBtn" class="cta-button">
                            <i class="fas fa-calendar-check"></i>
                            احجز استشارتك الآن
                        </button>
                    </div>
                </div>

                <div class="card-footer">
                    <button id="restartBtn" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-redo btn-icon"></i>
                        إعادة الاختبار
                    </button>
                    <button id="shareResultsBtn" class="btn btn-primary btn-block mt-2">
                        <i class="fas fa-share-alt btn-icon"></i>
                        مشاركة النتائج
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // تعريف النموذج المطور لاختبار توازن للشخصية
        class PersonalityTest {
            constructor() {
                // بيانات الأسئلة مع تحديث القيم حسب مقياس هيرمان
                this.questions = [
                    // أسئلة المرحلة الأولى (درجة 5) - سؤال واحد من كل فئة
                    {
                        id: 1,
                        text: "أستمتع بتحليل المشكلات المعقدة وفهم الأنظمة بعمق",
                        category: "A",
                        value: 5
                    },
                    {
                        id: 2,
                        text: "أهتم بترتيب وتنظيم الأشياء بدقة متناهية",
                        category: "B",
                        value: 5
                    },
                    {
                        id: 3,
                        text: "أجيد التواصل مع الآخرين وفهم مشاعرهم واحتياجاتهم",
                        category: "C",
                        value: 5
                    },
                    {
                        id: 4,
                        text: "لدي قدرة على التفكير الإبداعي وتطوير أفكار مبتكرة",
                        category: "D",
                        value: 5
                    },

                    // أسئلة المرحلة الثانية (درجة 4) - سؤال واحد من كل فئة
                    {
                        id: 5,
                        text: "أفضل العمل بالأرقام والبيانات والإحصائيات",
                        category: "A",
                        value: 4
                    },
                    {
                        id: 6,
                        text: "أتبع الخطوات والتعليمات بدقة وأهتم بالتفاصيل",
                        category: "B",
                        value: 4
                    },
                    {
                        id: 7,
                        text: "أستطيع فهم مشاعر الآخرين والتعامل معها بكفاءة",
                        category: "C",
                        value: 4
                    },
                    {
                        id: 8,
                        text: "أجد متعة في استكشاف الأفكار الجديدة والمفاهيم المبتكرة",
                        category: "D",
                        value: 4
                    },

                    // أسئلة المرحلة الثالثة (درجة 3) - سؤال واحد من كل فئة
                    {
                        id: 9,
                        text: "أفضل العمل بالمشاريع التي تتطلب التفكير المنطقي والتحليلي",
                        category: "A",
                        value: 3
                    },
                    {
                        id: 10,
                        text: "أحرص على إنهاء المهام في مواعيدها المحددة ووفق الخطط الموضوعة",
                        category: "B",
                        value: 3
                    },
                    {
                        id: 11,
                        text: "أستمتع بالعمل الجماعي والتفاعل مع الآخرين",
                        category: "C",
                        value: 3
                    },
                    {
                        id: 12,
                        text: "أميل إلى رؤية الصورة الكاملة والمستقبلية للأمور",
                        category: "D",
                        value: 3
                    },

                    // أسئلة المرحلة الرابعة (درجة 2) - سؤال واحد من كل فئة
                    {
                        id: 13,
                        text: "أعتمد على المنطق والتحليل في اتخاذ القرارات",
                        category: "A",
                        value: 2
                    },
                    {
                        id: 14,
                        text: "أجيد تنفيذ المهام بدقة وفق الإجراءات المحددة",
                        category: "B",
                        value: 2
                    },
                    {
                        id: 15,
                        text: "أجيد التعبير عن أفكاري ومشاعري وأتواصل بسهولة مع الآخرين",
                        category: "C",
                        value: 2
                    },
                    {
                        id: 16,
                        text: "أنظر للمستقبل وأتخيل الاحتمالات بشكل إبداعي",
                        category: "D",
                        value: 2
                    },

                    // أسئلة المرحلة الخامسة (درجة 1) - سؤال واحد من كل فئة
                    {
                        id: 17,
                        text: "أفضل البحث عن الحقائق والبيانات قبل اتخاذ القرارات",
                        category: "A",
                        value: 1
                    },
                    {
                        id: 18,
                        text: "أهتم بالتخطيط المسبق وتنظيم الأعمال قبل البدء بها",
                        category: "B",
                        value: 1
                    },
                    {
                        id: 19,
                        text: "أشعر بمشاعر الآخرين وأهتم بآرائهم وأفكارهم",
                        category: "C",
                        value: 1
                    },
                    {
                        id: 20,
                        text: "أتقبل التغيير وأبحث عن طرق جديدة لتحسين الأشياء",
                        category: "D",
                        value: 1
                    }
                ];

                // بيانات السمات
                this.traits = {
                    A: [
                        "التفكير المنطقي والتحليلي",
                        "القدرة على فهم النماذج الرياضية والعلمية",
                        "التفكير النقدي وتحليل المشكلات",
                        "الاعتماد على الحقائق والبيانات",
                        "البحث عن الدقة والوضوح",
                        "البحث المنهجي والتجريبي",
                        "التحليل الدقيق للمعلومات",
                        "الاهتمام بالتفاصيل التقنية"
                    ],
                    B: [
                        "الالتزام بالمواعيد والإجراءات",
                        "التنظيم والترتيب والهيكلة",
                        "الدقة في التفاصيل وإتمام المهام",
                        "الالتزام بالقواعد والأنظمة",
                        "التخطيط المسبق واتباع الإجراءات",
                        "الميل للتحكم والضبط",
                        "الاستقرار والثبات في العمل",
                        "التنفيذ الدقيق للمهام"
                    ],
                    C: [
                        "التعاطف وفهم مشاعر الآخرين",
                        "مهارات التواصل والتفاعل الاجتماعي",
                        "العمل الجماعي والتعاون",
                        "الاهتمام بالعلاقات الإنسانية",
                        "الحساسية العاطفية والإدراك الاجتماعي",
                        "القدرة على الإقناع والتأثير",
                        "تقديم المساعدة والدعم للآخرين",
                        "القدرة على حل النزاعات والوساطة"
                    ],
                    D: [
                        "التفكير الإبداعي والابتكاري",
                        "التطلع للمستقبل والرؤية الشاملة",
                        "استكشاف الأفكار الجديدة",
                        "التفكير خارج الصندوق",
                        "حل المشكلات بطرق إبداعية",
                        "القدرة على التكيف مع التغيير",
                        "الرؤية الاستراتيجية بعيدة المدى",
                        "الميل للتجريب والمخاطرة"
                    ]
                };

                // حدود المراحل - 4 لكل مرحلة
                this.sectionLimits = {
                    1: 4,
                    2: 4,
                    3: 4,
                    4: 4,
                    5: 4
                };

                // تقييمات المراحل - القيم الفعلية لكل مرحلة
                this.sectionRatings = {
                    1: 5, // المرحلة الأولى تعطي تقييم 5
                    2: 4, // المرحلة الثانية تعطي تقييم 4
                    3: 3, // المرحلة الثالثة تعطي تقييم 3
                    4: 2, // المرحلة الرابعة تعطي تقييم 2
                    5: 1, // المرحلة الخامسة تعطي تقييم 1
                };

                // تهيئة حالة المستخدم
                this.resetUserState();

                // المؤشرات للعناصر في DOM
                this.elements = {};
            }

            // تهيئة حالة المستخدم
            resetUserState() {
                this.userState = {
                    personalInfo: {},
                    selections: {
                        1: [],
                        2: [],
                        3: [],
                        4: [],
                        5: []
                    },
                    results: {
                        A: 0,
                        B: 0,
                        C: 0,
                        D: 0
                    },
                    selectedQuestions: new Set(),
                    previouslySelectedQuestions: {},
                    currentSection: 1
                };
            }

            // تهيئة مراجع العناصر
            initializeElements() {
                // العناصر الرئيسية
                this.elements = {
                    loadingOverlay: document.getElementById('loadingOverlay'),
                    loadingText: document.getElementById('loadingText'),
                    registrationForm: document.getElementById('registrationForm'),
                    testContainer: document.getElementById('testContainer'),
                    resultsContainer: document.getElementById('resultsContainer'),
                    instructionModal: document.getElementById('instructionModal'),

                    // عناصر النموذج
                    fullName: document.getElementById('fullName'),
                    phone: document.getElementById('phone'),
                    email: document.getElementById('email'),
                    gender: document.querySelector('input[name="gender"]:checked'),

                    // أزرار
                    startTestBtn: document.getElementById('startTestBtn'),
                    startTestFromModal: document.getElementById('startTestFromModal'),
                    closeInstructionModal: document.getElementById('closeInstructionModal'),
                    prevBtn: document.getElementById('prevBtn'),
                    nextBtn: document.getElementById('nextBtn'),
                    submitBtn: document.getElementById('submitBtn'),
                    restartBtn: document.getElementById('restartBtn'),
                    shareResultsBtn: document.getElementById('shareResultsBtn'),
                    consultationBtn: document.getElementById('consultationBtn'),

                    // مؤشرات التقدم
                    progressBar: document.getElementById('progressBar'),
                    progressText: document.getElementById('progressText'),

                    // العدادات
                    counter1: document.getElementById('counter1'),
                    counter2: document.getElementById('counter2'),
                    counter3: document.getElementById('counter3'),
                    counter4: document.getElementById('counter4'),
                    counter5: document.getElementById('counter5'),

                    // قوائم الأسئلة
                    questionList1: document.getElementById('questionList1'),
                    questionList2: document.getElementById('questionList2'),
                    questionList3: document.getElementById('questionList3'),
                    questionList4: document.getElementById('questionList4'),
                    questionList5: document.getElementById('questionList5'),

                    // عناصر النتائج
                    scoreA: document.getElementById('scoreA'),
                    scoreB: document.getElementById('scoreB'),
                    scoreC: document.getElementById('scoreC'),
                    scoreD: document.getElementById('scoreD'),
                    progressA: document.getElementById('progressA'),
                    progressB: document.getElementById('progressB'),
                    progressC: document.getElementById('progressC'),
                    progressD: document.getElementById('progressD'),
                    radarData: document.getElementById('radarData'),
                    radarDotA: document.getElementById('radarDotA'),
                    radarDotB: document.getElementById('radarDotB'),
                    radarDotC: document.getElementById('radarDotC'),
                    radarDotD: document.getElementById('radarDotD'),
                    dominantProfile: document.getElementById('dominantProfile'),
                    traitsList: document.getElementById('traitsList'),
                    particleBg: document.getElementById('particleBg')
                };

                // إعداد مستمعي الأحداث
                this.setupEventListeners();

                // بدء التهيئة
                this.initialize();
            }

            // إعداد مستمعي الأحداث
            setupEventListeners() {
                // استخدام bind لضمان أن this تشير إلى الكلاس
                this.elements.startTestBtn.addEventListener('click', this.showInstructionModal.bind(this));
                this.elements.startTestFromModal.addEventListener('click', this.startTest.bind(this));
                this.elements.closeInstructionModal.addEventListener('click', this.closeInstructionModal.bind(this));
                this.elements.nextBtn.addEventListener('click', this.goToNextSection.bind(this));
                this.elements.prevBtn.addEventListener('click', this.goToPrevSection.bind(this));
                this.elements.submitBtn.addEventListener('click', this.submitTest.bind(this));
                this.elements.restartBtn.addEventListener('click', this.restartTest.bind(this));
                this.elements.shareResultsBtn.addEventListener('click', this.shareResults.bind(this));
                this.elements.consultationBtn.addEventListener('click', this.openConsultation.bind(this));
            }

            // تهيئة الاختبار
            initialize() {
                // إخفاء شاشة التحميل بعد تحميل الصفحة
                setTimeout(() => {
                    this.elements.loadingOverlay.style.opacity = '0';
                    setTimeout(() => {
                        this.elements.loadingOverlay.style.display = 'none';
                    }, 500);
                }, 1500);

                // تهيئة AOS للحركات
                if (typeof AOS !== 'undefined') {
                    AOS.init({
                        duration: 800,
                        once: true,
                        mirror: false,
                        offset: 50,
                        delay: 100
                    });
                }

                // تهيئة الأسئلة للمرحلة الأولى
                this.populateQuestions(1);

                // إضافة خلفية الجسيمات
                this.createParticles();
            }

            // إظهار نافذة التعليمات
            showInstructionModal() {
                // التحقق من صحة النموذج
                const fullName = this.elements.fullName.value;
                const phone = this.elements.phone.value;
                const email = this.elements.email.value;

                if (!fullName || !phone || !email) {
                    this.showAlert('يرجى ملء جميع الحقول المطلوبة', 'error');
                    return;
                }

                // التحقق من صحة البريد الإلكتروني
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    this.showAlert('يرجى إدخال بريد إلكتروني صحيح', 'error');
                    return;
                }

                // التحقق من صحة رقم الهاتف
                const phoneRegex = /^[0-9+\s-]{8,15}$/;
                if (!phoneRegex.test(phone)) {
                    this.showAlert('يرجى إدخال رقم هاتف صحيح', 'error');
                    return;
                }

                // إظهار نافذة التعليمات
                this.elements.instructionModal.style.visibility = 'visible';
                this.elements.instructionModal.style.opacity = '1';
                this.elements.instructionModal.classList.add('show');

                // تطبيق حركة الدخول على المودال
                const modal = this.elements.instructionModal.querySelector('.modal');
                if (modal) {
                    modal.style.transform = 'translateY(0) scale(1)';
                    modal.style.opacity = '1';
                }
            }

            // إغلاق نافذة التعليمات
            closeInstructionModal() {
                const modal = this.elements.instructionModal.querySelector('.modal');
                if (modal) {
                    modal.style.transform = 'translateY(50px) scale(0.95)';
                    modal.style.opacity = '0';
                }

                setTimeout(() => {
                    this.elements.instructionModal.style.opacity = '0';
                    this.elements.instructionModal.classList.remove('show');

                    setTimeout(() => {
                        this.elements.instructionModal.style.visibility = 'hidden';
                    }, 500);
                }, 300);
            }

            // إنشاء جسيمات للخلفية
            createParticles() {
                const particleContainer = this.elements.particleBg;
                if (!particleContainer) return;

                for (let i = 0; i < 30; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    particle.style.top = `${Math.random() * 100}%`;
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.opacity = `${Math.random() * 0.5 + 0.1}`;
                    particle.style.width = `${Math.random() * 8 + 2}px`;
                    particle.style.height = particle.style.width;
                    particle.style.animationDelay = `${Math.random() * 5}s`;
                    particle.style.animationDuration = `${Math.random() * 10 + 5}s`;
                    particleContainer.appendChild(particle);
                }
            }

            // بدء الاختبار
            startTest() {
                // حفظ المعلومات الشخصية
                this.userState.personalInfo = {
                    name: this.elements.fullName.value,
                    phone: this.elements.phone.value,
                    email: this.elements.email.value,
                    gender: document.querySelector('input[name="gender"]:checked').value,
                    date: new Date().toLocaleString('ar-SA')
                };

                // إغلاق نافذة التعليمات إذا كانت مفتوحة
                if (this.elements.instructionModal.classList.contains('show')) {
                    this.closeInstructionModal();
                }

                // إظهار تأثير الانتقال
                this.elements.registrationForm.classList.add('fade-out');

                setTimeout(() => {
                    // إخفاء نموذج التسجيل وإظهار حاوية الاختبار
                    this.elements.registrationForm.style.display = 'none';
                    this.elements.testContainer.style.display = 'block';

                    // إضافة تأثير متحرك لحاوية الاختبار
                    setTimeout(() => {
                        this.elements.testContainer.classList.add('fade-in');
                    }, 50);

                    // تهيئة الأسئلة وتحديث واجهة المستخدم
                    this.populateQuestions(1);
                    this.updateProgress();

                    // عرض رسالة نجاح
                    this.showAlert('تم تسجيل بياناتك بنجاح، ابدأ باختيار ٤ صفات تنطبق عليك بشكل كبير جداً', 'success');

                    // التمرير إلى الأعلى
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 300);
            }

            // ملء الأسئلة لمرحلة معينة
            populateQuestions(section) {
                const container = document.getElementById(`questionList${section}`);
                if (!container) return;

                container.innerHTML = '';

                // نسخ مصفوفة الأسئلة لتجنب تعديل الأصلية
                let questionsToDisplay = [...this.questions];

                // ترتيب الأسئلة بطريقة عشوائية لتجنب النمطية
                questionsToDisplay = this.shuffleArray(questionsToDisplay);

                // لكل سؤال، تحقق مما إذا كان محددًا في المراحل السابقة
                questionsToDisplay.forEach((question, index) => {
                    const questionCard = document.createElement('div');
                    questionCard.className = `question-card ${question.category.toLowerCase()}-category`;
                    questionCard.setAttribute('data-id', question.id);
                    questionCard.setAttribute('data-aos', 'fade-up');
                    questionCard.setAttribute('data-aos-delay', (index % 5) * 100);

                    // تحقق مما إذا كان هذا السؤال محددًا في هذه المرحلة
                    const isSelectedInCurrentSection = this.userState.selections[section].includes(question.id);

                    // تحقق مما إذا كان هذا السؤال محددًا في المراحل السابقة
                    let isSelectedInPreviousSection = false;
                    let previousSectionRating = null;

                    for (let prevSection = 1; prevSection <= 5; prevSection++) {
                        if (prevSection !== section && this.userState.selections[prevSection].includes(question.id)) {
                            isSelectedInPreviousSection = true;
                            previousSectionRating = this.sectionRatings[prevSection];
                            break;
                        }
                    }

                    // استخدام نفس الأيقونة لجميع الفئات لإخفاء نوع الفئة
                    const iconClass = 'fas fa-check-circle';

                    // إضافة فئة محددة إذا كان هذا السؤال محددًا في المرحلة الحالية
                    if (isSelectedInCurrentSection) {
                        questionCard.classList.add('selected');
                    }

                    // إذا كان محددًا في مرحلة سابقة، اعرضه كتحديد سابق
                    if (isSelectedInPreviousSection) {
                        questionCard.classList.add('previous-selection');

                        questionCard.innerHTML = `
                <div class="question-header">
                    <div class="question-icon">
                        <i class="${iconClass}"></i>
                    </div>
                    <div class="question-text">${question.text}</div>
                </div>
                <div class="question-rating">${previousSectionRating}</div>
            `;
                    } else {
                        // إذا لم يكن محددًا في مرحلة سابقة، اعرضه عاديًا مع تقييم المرحلة الحالية
                        questionCard.innerHTML = `
                <div class="question-header">
                    <div class="question-icon">
                        <i class="${iconClass}"></i>
                    </div>
                    <div class="question-text">${question.text}</div>
                </div>
                <div class="question-rating">${this.sectionRatings[section]}</div>
                <div class="selected-badge">
                    <i class="fas fa-check"></i>
                </div>
            `;

                        // إضافة معالج النقر فقط إذا لم يكن محددًا في مرحلة سابقة
                        questionCard.addEventListener('click', () => {
                            this.handleQuestionSelection(section, question.id);
                        });
                    }

                    container.appendChild(questionCard);
                });

                // تحديث العداد لهذه المرحلة
                this.updateCounter(section);

                // تحديث AOS
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            }

            // معالجة اختيار السؤال
            handleQuestionSelection(section, questionId) {
                const sectionSelections = this.userState.selections[section];
                const sectionLimit = this.sectionLimits[section];

                // تحقق مما إذا كان السؤال محددًا بالفعل
                const isSelected = sectionSelections.includes(questionId);

                // تحقق مما إذا كان هذا السؤال محددًا في المراحل السابقة
                let isSelectedInPreviousSection = false;
                for (let prevSection = 1; prevSection <= 5; prevSection++) {
                    if (prevSection !== section && this.userState.selections[prevSection].includes(questionId)) {
                        isSelectedInPreviousSection = true;
                        break;
                    }
                }

                // تخطي إذا كان محددًا بالفعل في مرحلة سابقة
                if (isSelectedInPreviousSection) {
                    return;
                }

                if (isSelected) {
                    // إزالة من التحديد
                    this.userState.selections[section] = sectionSelections.filter(id => id !== questionId);

                    // الحصول على حاوية المرحلة الحالية المحددة
                    const container = document.getElementById(`questionList${section}`);
                    // البحث عن البطاقة فقط داخل هذه الحاوية
                    const card = container.querySelector(`.question-card[data-id="${questionId}"]`);

                    if (card) {
                        card.classList.remove('selected');

                        // إضافة حركة بسيطة
                        card.classList.add('animate__animated', 'animate__headShake');
                        setTimeout(() => {
                            card.classList.remove('animate__animated', 'animate__headShake');
                        }, 1000);
                    }
                } else {
                    // التحقق مما إذا تم الوصول إلى الحد الأقصى
                    if (sectionSelections.length >= sectionLimit) {
                        this.showAlert(`يمكنك اختيار ${sectionLimit} عناصر فقط في هذه المرحلة`, 'error');
                        return;
                    }

                    // إضافة إلى التحديد
                    sectionSelections.push(questionId);

                    // الحصول على حاوية المرحلة الحالية المحددة
                    const container = document.getElementById(`questionList${section}`);
                    // البحث عن البطاقة فقط داخل هذه الحاوية
                    const card = container.querySelector(`.question-card[data-id="${questionId}"]`);

                    if (card) {
                        card.classList.add('selected');

                        // التأكد من إظهار الرقم وعلامة التحديد
                        const ratingElement = card.querySelector('.question-rating');
                        const badgeElement = card.querySelector('.selected-badge');

                        if (ratingElement) {
                            ratingElement.style.opacity = '1';
                            ratingElement.style.transform = 'scale(1) rotate(0deg)';
                        }

                        if (badgeElement) {
                            badgeElement.style.opacity = '1';
                            badgeElement.style.transform = 'scale(1) rotate(0deg)';
                        }

                        // إضافة حركة التحديد
                        card.classList.add('animate__animated', 'animate__pulse');
                        setTimeout(() => {
                            card.classList.remove('animate__animated', 'animate__pulse');
                        }, 1000);
                    }
                }

                // تحديث العداد
                this.updateCounter(section);

                // وضع علامة على السؤال كمحدد في حالة المستخدم
                if (isSelected) {
                    this.userState.selectedQuestions.delete(questionId);
                } else {
                    this.userState.selectedQuestions.add(questionId);
                }

                // تمكين/تعطيل زر التالي
                this.updateNavigationButtons();
            }

            // تحديث العداد لمرحلة معينة
            updateCounter(section) {
                const counter = document.getElementById(`counter${section}`);
                if (!counter) return;

                const selected = this.userState.selections[section].length;
                const limit = this.sectionLimits[section];
                counter.textContent = `${selected}/${limit}`;

                // تطبيق تمييز مرئي إذا كان مكتملاً
                if (selected === limit) {
                    counter.style.backgroundColor = 'rgba(255, 255, 255, 0.4)';
                    counter.style.color = '#fff';
                    counter.style.fontWeight = '800';

                    // عرض إشعار إذا كان مكتملاً
                    if (selected === limit && !counter.dataset.notified) {
                        counter.dataset.notified = 'true';

                        // حركة اهتزاز صغيرة على العداد
                        counter.classList.add('animate__animated', 'animate__rubberBand');
                        setTimeout(() => {
                            counter.classList.remove('animate__animated', 'animate__rubberBand');
                        }, 1000);

                        if (section < 5) {
                            this.showAlert('أحسنت! يمكنك الانتقال إلى المرحلة التالية', 'success');
                        } else {
                            this.showAlert('أحسنت! يمكنك الآن إنهاء الاختبار ومشاهدة النتائج', 'success');
                        }
                    }
                } else {
                    counter.style.backgroundColor = 'rgba(255, 255, 255, 0.2)';
                    counter.style.color = '#fff';
                    counter.style.fontWeight = '700';
                    counter.dataset.notified = 'false';
                }

                // تحديث أزرار التنقل
                this.updateNavigationButtons();
            }

            // تحديث أزرار التنقل
            updateNavigationButtons() {
                const nextBtn = this.elements.nextBtn;
                const submitBtn = this.elements.submitBtn;
                const section = this.userState.currentSection;
                const selected = this.userState.selections[section].length;
                const limit = this.sectionLimits[section];

                if (section < 5) {
                    nextBtn.disabled = selected < limit;
                    nextBtn.style.display = 'block';
                    submitBtn.style.display = 'none';
                } else {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'block';
                    submitBtn.disabled = selected < limit;
                }
            }

            // الانتقال إلى المرحلة التالية
            goToNextSection() {
                const currentSelections = this.userState.selections[this.userState.currentSection];
                const currentLimit = this.sectionLimits[this.userState.currentSection];

                if (currentSelections.length < currentLimit) {
                    this.showAlert(`يجب عليك اختيار ${currentLimit} عناصر قبل الانتقال للمرحلة التالية`, 'error');
                    return;
                }

                // تأثير الانتقال
                const currentSection = document.getElementById(`section${this.userState.currentSection}`);
                currentSection.classList.add('animate__animated', 'animate__fadeOutRight');

                setTimeout(() => {
                    this.goToSection(this.userState.currentSection + 1);

                    // إزالة فئات الحركة
                    currentSection.classList.remove('animate__animated', 'animate__fadeOutRight');

                    // إضافة حركة دخول للقسم الجديد
                    const newSection = document.getElementById(`section${this.userState.currentSection}`);
                    newSection.classList.add('animate__animated', 'animate__fadeInLeft');

                    setTimeout(() => {
                        newSection.classList.remove('animate__animated', 'animate__fadeInLeft');
                    }, 500);
                }, 300);
            }

            // الانتقال إلى المرحلة السابقة
            goToPrevSection() {
                // تأثير الانتقال
                const currentSection = document.getElementById(`section${this.userState.currentSection}`);
                currentSection.classList.add('animate__animated', 'animate__fadeOutLeft');

                setTimeout(() => {
                    this.goToSection(this.userState.currentSection - 1);

                    // إزالة فئات الحركة
                    currentSection.classList.remove('animate__animated', 'animate__fadeOutLeft');

                    // إضافة حركة دخول للقسم الجديد
                    const newSection = document.getElementById(`section${this.userState.currentSection}`);
                    newSection.classList.add('animate__animated', 'animate__fadeInRight');

                    setTimeout(() => {
                        newSection.classList.remove('animate__animated', 'animate__fadeInRight');
                    }, 500);
                }, 300);
            }

            // الانتقال إلى مرحلة محددة
            goToSection(section) {
                // التأكد من أن المرحلة صالحة
                if (section < 1 || section > 5) return;

                // إخفاء جميع المراحل
                document.querySelectorAll('.test-section').forEach(el => {
                    el.style.display = 'none';
                });

                // عرض المرحلة الحالية
                document.getElementById(`section${section}`).style.display = 'block';

                // تحديث المرحلة الحالية
                this.userState.currentSection = section;

                // تحديث الأزرار
                const prevBtn = this.elements.prevBtn;
                const nextBtn = this.elements.nextBtn;
                const submitBtn = this.elements.submitBtn;

                prevBtn.style.display = section > 1 ? 'block' : 'none';

                if (section < 5) {
                    nextBtn.style.display = 'block';
                    submitBtn.style.display = 'none';
                } else {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'block';
                }

                // ملء الأسئلة
                this.populateQuestions(section);

                // تحديث التقدم
                this.updateProgress();

                // تحديث الخطوات
                this.updateSteps(section);

                // التمرير إلى الأعلى
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                // تحديث حالة أزرار التنقل
                this.updateNavigationButtons();
            }

            // تحديث شريط التقدم
            updateProgress() {
                const progressBar = this.elements.progressBar;
                const progressText = this.elements.progressText;

                if (!progressBar || !progressText) return;

                // تعديل: جعل التقدم مرتبطًا بالمرحلة الحالية (0%, 20%, 40%, 60%, 80%, 100%)
                const progressPercent = (this.userState.currentSection - 1) * 20;

                // تحريك شريط التقدم بشكل متحرك
                this.animateProgressBar(progressBar, progressText, progressPercent);
            }

            // تحريك شريط التقدم
            animateProgressBar(progressBar, progressText, targetValue) {
                let currentWidth = parseInt(progressBar.style.width) || 0;
                let textValue = parseInt(progressText.textContent) || 0;
                const increment = targetValue > currentWidth ? 1 : -1;

                const animate = () => {
                    if ((increment > 0 && currentWidth < targetValue) ||
                        (increment < 0 && currentWidth > targetValue)) {
                        currentWidth += increment;
                        progressBar.style.width = `${currentWidth}%`;

                        textValue += increment;
                        progressText.textContent = `${textValue}%`;

                        requestAnimationFrame(animate);
                    }
                };

                animate();
            }

            // تحديث الخطوات
            updateSteps(currentStep) {
                document.querySelectorAll('.step').forEach(step => {
                    const stepNum = parseInt(step.getAttribute('data-step'));
                    step.classList.remove('active', 'completed');

                    if (stepNum < currentStep) {
                        step.classList.add('completed');
                    } else if (stepNum === currentStep) {
                        step.classList.add('active');
                    }
                });
            }

            // إرسال الاختبار
            submitTest() {
                // التحقق من اكتمال جميع المراحل
                let allCompleted = true;
                let incompleteSections = [];

                for (let section = 1; section <= 5; section++) {
                    const selected = this.userState.selections[section].length;
                    const limit = this.sectionLimits[section];

                    if (selected < limit) {
                        allCompleted = false;
                        incompleteSections.push(section);
                    }
                }

                if (!allCompleted) {
                    const sectionText = incompleteSections.length === 1 ?
                        `المرحلة ${incompleteSections[0]}` :
                        `المراحل ${incompleteSections.join(' و ')}`;

                    this.showAlert(`يجب عليك إكمال ${sectionText} قبل إظهار النتائج`, 'error');
                    return;
                }

                // عرض شاشة التحميل مع رسالة
                this.elements.loadingOverlay.style.display = 'flex';
                this.elements.loadingText.textContent = 'جاري تحليل نتائج الاختبار...';

                setTimeout(() => {
                    this.elements.loadingOverlay.style.opacity = '1';

                    // محاكاة وقت الحساب
                    setTimeout(() => {
                        this.calculateResults();

                        // إخفاء شاشة التحميل
                        this.elements.loadingOverlay.style.opacity = '0';
                        setTimeout(() => {
                            this.elements.loadingOverlay.style.display = 'none';

                            // عرض النتائج
                            this.showResults();

                            // حفظ النتائج في قاعدة البيانات باستخدام AJAX
                            this.saveResultsToDatabase();

                            // إضافة تأثير الاحتفال
                            this.createConfetti();
                        }, 500);
                    }, 1500);
                }, 100);
            }

            // حفظ النتائج في قاعدة البيانات
            // Función corregida para guardar los resultados en la base de datos
            saveResultsToDatabase() {
                // Mostrar alerta de guardado
                this.showAlert('جاري حفظ النتائج...', 'info');

                // Preparar los datos para enviar
                const data = {
                    personalInfo: this.userState.personalInfo,
                    results: this.userState.results,
                    dominantCategory: this.userState.dominantCategory,
                    selections: this.userState.selections
                };

                console.log('Enviando datos:', data);

                // Usar fetch API para enviar los datos con ruta absoluta
                fetch(window.location.href.substring(0, window.location.href.lastIndexOf('/') + 1) + 'save_result.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(result => {
                        if (result.success) {
                            console.log('Resultados guardados exitosamente:', result);
                            this.showAlert('تم حفظ النتائج بنجاح!', 'success');
                        } else {
                            console.error('Error al guardar resultados:', result.message);
                            this.showAlert('حدث خطأ أثناء حفظ النتائج: ' + result.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error al enviar datos:', error);
                        this.showAlert('حدث خطأ أثناء إرسال البيانات. يرجى المحاولة مرة أخرى.', 'error');
                    });
            }

            // إضافة تأثير احتفالي
            createConfetti() {
                const container = document.body;
                const confettiCount = 100;
                const colors = [
                    '#54c8e8', // الأزرق الفاتح
                    '#083347', // الأزرق الداكن
                    '#ffffff', // الأبيض
                    '#2ecc71', // الأخضر
                    '#f39c12' // البرتقالي
                ];

                for (let i = 0; i < confettiCount; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.left = `${Math.random() * 100}vw`;
                    confetti.style.top = '-20px';
                    confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
                    confetti.style.width = `${Math.random() * 10 + 5}px`;
                    confetti.style.height = `${Math.random() * 10 + 5}px`;
                    confetti.style.opacity = Math.random() * 0.7 + 0.3;
                    confetti.style.position = 'fixed';
                    confetti.style.zIndex = 9998;
                    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';

                    // الحركة
                    confetti.style.animation = `fall ${Math.random() * 3 + 2}s linear forwards`;
                    confetti.style.animationDelay = `${Math.random() * 2}s`;

                    // إضافة الحركة
                    const fallKeyframes = `
                @keyframes fall {
                    to {
                        transform: translateY(100vh) rotate(${Math.random() * 1000}deg);
                        opacity: 0;
                    }
                }`;

                    // إضافة نمط الحركة إذا لم يكن موجودًا بالفعل
                    if (!document.querySelector('#confetti-animation')) {
                        const styleSheet = document.createElement('style');
                        styleSheet.id = 'confetti-animation';
                        styleSheet.innerHTML = fallKeyframes;
                        document.head.appendChild(styleSheet);
                    }

                    container.appendChild(confetti);

                    // إزالة العنصر بعد الانتهاء
                    setTimeout(() => {
                        if (container.contains(confetti)) {
                            container.removeChild(confetti);
                        }
                    }, 5000);
                }
            }

            // حساب النتائج - نظام حساب جديد صحيح
            calculateResults() {
                // إعادة تعيين النتائج
                this.userState.results = {
                    A: 0,
                    B: 0,
                    C: 0,
                    D: 0
                };

                // حساب مجموع النقاط لكل فئة
                for (let section = 1; section <= 5; section++) {
                    const sectionValue = this.sectionRatings[section]; // قيمة المرحلة (5, 4, 3, 2, 1)

                    this.userState.selections[section].forEach(questionId => {
                        // البحث عن السؤال من مصفوفة الأسئلة
                        const question = this.questions.find(q => q.id === questionId);
                        if (question) {
                            // إضافة قيمة المرحلة إلى فئة السؤال
                            this.userState.results[question.category] += sectionValue;
                        }
                    });
                }

                // حساب مجموع كل النقاط
                let totalPoints = 0;
                for (let category in this.userState.results) {
                    totalPoints += this.userState.results[category];
                }

                console.log('Raw Scores:', {
                    ...this.userState.results
                }, 'Total Points:', totalPoints);

                // تحويل النقاط إلى نسب مئوية
                for (let category in this.userState.results) {
                    if (totalPoints > 0) {
                        this.userState.results[category] = Math.round((this.userState.results[category] / totalPoints) * 100);
                    } else {
                        // في حالة عدم وجود نقاط (لا ينبغي أن تحدث)، توزيع متساوٍ
                        this.userState.results[category] = 25;
                    }
                }

                console.log('Calculated Percentages:', {
                    ...this.userState.results
                });

                // تصحيح أي فوارق في الإجمالي حتى يكون 100%
                this.normalizePercentages(this.userState.results);

                console.log('Normalized Percentages:', {
                    ...this.userState.results
                });

                // تحديد النمط السائد
                let dominantCategory = 'A';
                let maxScore = this.userState.results.A;

                for (let category in this.userState.results) {
                    if (this.userState.results[category] > maxScore) {
                        maxScore = this.userState.results[category];
                        dominantCategory = category;
                    }
                }

                this.userState.dominantCategory = dominantCategory;
            }

            // معايرة النسب المئوية للتأكد من أن مجموعها 100%
            normalizePercentages(results) {
                // حساب المجموع الحالي
                let total = 0;
                for (let category in results) {
                    total += results[category];
                }

                // إذا كان المجموع بالضبط 100، لا داعي لأي معايرة
                if (total === 100) return;

                // إذا كان المجموع مختلفاً عن 100
                // نحسب الفرق الذي يجب إضافته/طرحه
                const diff = 100 - total;

                if (diff !== 0) {
                    // تحديد الفئات حسب قيمها (من الأعلى إلى الأقل)
                    const sortedCategories = Object.keys(results)
                        .sort((a, b) => results[b] - results[a]);

                    if (diff > 0) {
                        // إذا كان المجموع أقل من 100، أضف إلى الفئة الأكبر
                        results[sortedCategories[0]] += diff;
                    } else {
                        // إذا كان المجموع أكبر من 100، اطرح من الفئة الأصغر
                        // مع ضمان ألا تكون النتيجة سالبة
                        let remainingDiff = diff;
                        let i = sortedCategories.length - 1;

                        while (remainingDiff < 0 && i >= 0) {
                            const category = sortedCategories[i];

                            // نتأكد من أن الفئة لا تصبح سالبة
                            const adjustAmount = Math.max(-results[category], remainingDiff);
                            results[category] += adjustAmount;
                            remainingDiff -= adjustAmount;

                            i--;
                        }

                        // إذا بقي فرق، وزعه على الفئات المتبقية
                        if (remainingDiff < 0) {
                            for (i = 0; i < sortedCategories.length && remainingDiff < 0; i++) {
                                const category = sortedCategories[i];
                                results[category] += remainingDiff;
                                remainingDiff = 0;
                            }
                        }
                    }
                }

                // تحقق نهائي من المجموع
                total = 0;
                for (let category in results) {
                    total += results[category];
                }

                if (total !== 100) {
                    console.error("خطأ في المعايرة! المجموع النهائي ليس 100%:", total);
                    // تعديل نهائي إذا استمر الخطأ (يجب ألا يحدث)
                    const diff = 100 - total;
                    let maxCategory = Object.keys(results).reduce((a, b) => results[a] > results[b] ? a : b);
                    results[maxCategory] += diff;
                }
            }

            // عرض النتائج
            showResults() {
                const testContainer = this.elements.testContainer;
                const resultsContainer = this.elements.resultsContainer;

                // تأثير الانتقال
                testContainer.classList.add('animate__animated', 'animate__fadeOut');

                setTimeout(() => {
                    // إخفاء حاوية الاختبار
                    testContainer.style.display = 'none';

                    // عرض حاوية النتائج
                    resultsContainer.style.display = 'block';
                    resultsContainer.classList.add('animate__animated', 'animate__fadeIn');

                    // تنظيف الحركات
                    testContainer.classList.remove('animate__animated', 'animate__fadeOut');

                    setTimeout(() => {
                        resultsContainer.classList.remove('animate__animated', 'animate__fadeIn');

                        // تحديث النقاط مع الحركة
                        this.animateScore('scoreA', this.userState.results.A);
                        this.animateScore('scoreB', this.userState.results.B);
                        this.animateScore('scoreC', this.userState.results.C);
                        this.animateScore('scoreD', this.userState.results.D);

                        // تحديث أشرطة التقدم
                        setTimeout(() => {
                            document.getElementById('progressA').style.width = `${this.userState.results.A}%`;
                            document.getElementById('progressB').style.width = `${this.userState.results.B}%`;
                            document.getElementById('progressC').style.width = `${this.userState.results.C}%`;
                            document.getElementById('progressD').style.width = `${this.userState.results.D}%`;
                        }, 500);

                        // تحديث مخطط الرادار
                        setTimeout(() => {
                            this.updateRadarChart();
                        }, 1000);

                        // تحديث النمط السائد
                        this.updateDominantProfile();

                        // تحديث قائمة السمات
                        this.updateTraitsList();

                        // تحديث AOS
                        if (typeof AOS !== 'undefined') {
                            AOS.refresh();
                        }

                        // التمرير إلى الأعلى
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 200);
                }, 500);
            }

            // تحريك عداد النقاط
            animateScore(elementId, targetScore) {
                const element = document.getElementById(elementId);
                if (!element) return;

                let currentScore = 0;
                const duration = 1500; // 1.5 ثانية
                const interval = 20; // 20 ميلي ثانية
                const steps = duration / interval;
                const increment = targetScore / steps;

                const animation = setInterval(() => {
                    currentScore += increment;
                    if (currentScore >= targetScore) {
                        currentScore = targetScore;
                        clearInterval(animation);

                        // إضافة حركة توكيد عند الانتهاء
                        element.classList.add('animate__animated', 'animate__heartBeat');
                        setTimeout(() => {
                            element.classList.remove('animate__animated', 'animate__heartBeat');
                        }, 1000);
                    }
                    element.textContent = `${Math.round(currentScore)}`;
                }, interval);
            }

            // تحديث مخطط الرادار بشكل متقدم
            updateRadarChart() {
                const {
                    A,
                    B,
                    C,
                    D
                } = this.userState.results;

                // حساب المواقع للنقاط (من مركز المخطط)
                const centerX = 50;
                const centerY = 50;
                const maxDistance = 45; // أقصى مسافة من المركز
                const minDistance = 15; // الحد الأدنى للمسافة لضمان عدم اقتراب النقاط كثيرًا من المركز

                // حساب المسافات بناءً على النقاط (0-100٪)
                // قياس النقاط لتكون بين minDistance و maxDistance
                const scaleDistance = (score) => {
                    return minDistance + ((score / 100) * (maxDistance - minDistance));
                };

                const distanceA = scaleDistance(A);
                const distanceB = scaleDistance(B);
                const distanceC = scaleDistance(C);
                const distanceD = scaleDistance(D);

                // وضع النقاط مع الحركة
                const dotA = this.elements.radarDotA;
                const dotB = this.elements.radarDotB;
                const dotC = this.elements.radarDotC;
                const dotD = this.elements.radarDotD;

                if (!dotA || !dotB || !dotC || !dotD) return;

                // حساب المواقع (الزاوية بالراديان)
                // A في الأعلى (0 درجة)، B في اليمين (90 درجة)،
                // C في الأسفل (180 درجة)، D في اليسار (270 درجة)
                const aX = centerX;
                const aY = centerY - distanceA;
                const bX = centerX + distanceB;
                const bY = centerY;
                const cX = centerX;
                const cY = centerY + distanceC;
                const dX = centerX - distanceD;
                const dY = centerY;

                // وضع النقاط مع الحركة
                this.animateDot(dotA, aX, aY, 0);
                this.animateDot(dotB, bX, bY, 200);
                this.animateDot(dotC, cX, cY, 400);
                this.animateDot(dotD, dX, dY, 600);

                // إنشاء مضلع بيانات الرادار
                const radarData = this.elements.radarData;
                if (!radarData) return;

                // إنشاء مسار القص (مضلع) استنادًا إلى مواضع النقاط
                const clipPath = `${aX}% ${aY}%, ${bX}% ${bY}%, ${cX}% ${cY}%, ${dX}% ${dY}%`;

                // حركة متأخرة للمضلع
                setTimeout(() => {
                    radarData.style.clipPath = `polygon(${clipPath})`;
                }, 800);
            }

            // تحريك النقطة
            animateDot(dot, targetX, targetY, delay) {
                if (!dot) return;

                // الحصول على الموضع الحالي
                const currentX = parseFloat(dot.style.left) || 50;
                const currentY = parseFloat(dot.style.top) || 50;

                // مدة الحركة
                const duration = 800;
                const startTime = Date.now() + delay;

                const animate = () => {
                    const now = Date.now();
                    if (now < startTime) {
                        requestAnimationFrame(animate);
                        return;
                    }

                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // دالة تخفيف للحركة السلسة
                    const easeOutBack = (x) => {
                        const c1 = 1.70158;
                        const c3 = c1 + 1;
                        return 1 + c3 * Math.pow(x - 1, 3) + c1 * Math.pow(x - 1, 2);
                    };

                    const easedProgress = easeOutBack(progress);

                    const x = currentX + (targetX - currentX) * easedProgress;
                    const y = currentY + (targetY - currentY) * easedProgress;

                    dot.style.left = `${x}%`;
                    dot.style.top = `${y}%`;

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        // إضافة تأثير النبض عند انتهاء الحركة
                        dot.classList.add('animate__animated', 'animate__pulse');
                        setTimeout(() => {
                            dot.classList.remove('animate__animated', 'animate__pulse');
                        }, 1000);
                    }
                };

                requestAnimationFrame(animate);
            }

            // تحديث النمط السائد
            updateDominantProfile() {
                const dominantDiv = this.elements.dominantProfile;
                if (!dominantDiv) return;

                let profileName, profileDescription, profileIcon;

                switch (this.userState.dominantCategory) {
                    case 'A':
                        profileName = 'المنطقي التحليلي';
                        profileDescription = 'أنت صاحب تفكير منطقي وتحليلي، تميل للاعتماد على الحقائق والبيانات والمنطق في اتخاذ القرارات. لديك قدرة عالية على التفكير النقدي وحل المشكلات المعقدة. تتميز بقدرتك على فهم النظريات والمفاهيم المجردة وتحليلها. تفضل التعامل مع الأرقام والبيانات والحقائق الموضوعية وتميل إلى تحليل المشكلات بشكل منهجي.';
                        profileIcon = 'fas fa-brain';
                        break;
                    case 'B':
                        profileName = 'المنظم التنفيذي';
                        profileDescription = 'أنت شخص منظم ومرتب، تميل للاهتمام بالتفاصيل والخطوات التنفيذية. تحرص على الدقة والالتزام بالقواعد والإجراءات. تتميز بقدرتك على وضع الخطط وتنفيذها بدقة وانضباط. أنت شخص عملي وموثوق، تقدر النظام والاستقرار وتعمل بمنهجية واضحة. تهتم بالجدولة الزمنية وإدارة الوقت بكفاءة عالية.';
                        profileIcon = 'fas fa-tasks';
                        break;
                    case 'C':
                        profileName = 'العاطفي الاجتماعي';
                        profileDescription = 'أنت شخص اجتماعي وعاطفي، تهتم بالتواصل مع الآخرين وبناء العلاقات. لديك قدرة عالية على فهم مشاعر الآخرين والتعاطف معهم. تتميز بمهاراتك في التواصل والاستماع والتعبير عن الأفكار بطريقة مفهومة. تهتم بالعمل الجماعي والتعاون وتحرص على مراعاة مشاعر الآخرين عند اتخاذ القرارات. لديك ذكاء عاطفي مرتفع يساعدك على التعامل مع مختلف المواقف الاجتماعية.';
                        profileIcon = 'fas fa-heart';
                        break;
                    case 'D':
                        profileName = 'الابتكاري الاستراتيجي';
                        profileDescription = 'أنت مبدع ومبتكر، تميل للتفكير خارج الصندوق وإيجاد حلول إبداعية. لديك نظرة شمولية ورؤية مستقبلية. تهتم بالصورة الكبيرة وتستمتع باستكشاف الأفكار الجديدة والفرص المستقبلية. تميل إلى التجريب والمخاطرة المحسوبة وتفضل العمل في بيئة متغيرة ومتنوعة. لديك قدرة على تصور الاحتمالات المستقبلية وتطوير استراتيجيات مبتكرة للنجاح.';
                        profileIcon = 'fas fa-lightbulb';
                        break;
                }

                // إنشاء html النمط مع فئة الحركة - تصميم محسن
                dominantDiv.innerHTML = `
            <div class="dominant-profile-header prism-header animate__animated animate__fadeInDown">
                <div class="dominant-icon animate-pulse">
                    <i class="${profileIcon}"></i>
                </div>
                <div class="dominant-content">
                    <div class="dominant-title">النمط السائد في شخصيتك</div>
                    <div class="dominant-subtitle">بناءً على تحليل إجاباتك في اختبار توازن للشخصية</div>
                </div>
            </div>
            
            <div class="dominant-body">
                <div class="text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <h3 class="dominant-name">${profileName}</h3>
                </div>
                
                <p class="dominant-description animate__animated animate__fadeIn animate__delay-1s">
                    ${profileDescription}
                </p>
                
                <div class="trait-card mt-4 mb-2 animate__animated animate__fadeInLeft animate__delay-1s">
                    <div class="trait-card-header">
                        <div class="trait-card-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="trait-card-title">نسبة تطابق النمط السائد</h4>
                    </div>
                    <div class="trait-card-body text-center">
                        <div class="result-bar mb-2">
                            <div class="result-progress" style="width: ${this.userState.results[this.userState.dominantCategory]}%;"></div>
                        </div>
                        <div class="results-score" style="font-size: 2.5rem;">${this.userState.results[this.userState.dominantCategory]}%</div>
                    </div>
                </div>
            </div>
        `;
            }

            // تحديث قائمة السمات
            updateTraitsList() {
                const traitsList = this.elements.traitsList;
                if (!traitsList) return;

                traitsList.innerHTML = '';

                // ترتيب الفئات حسب النقاط
                const sortedCategories = Object.keys(this.userState.results).sort(
                    (a, b) => this.userState.results[b] - this.userState.results[a]
                );

                // إضافة بطاقات السمات المحسنة
                sortedCategories.forEach((category, categoryIndex) => {
                    // إظهار سمات الفئات ذات النقاط المهمة فقط (>10٪)
                    if (this.userState.results[category] >= 10) {
                        // عدد السمات المراد عرضها بناءً على نقاط الفئة
                        const traitsToShow = Math.max(2, Math.ceil((this.traits[category].length * this.userState.results[category]) / 100));

                        // الحصول على السمات
                        const categoryTraits = this.traits[category].slice(0, traitsToShow);

                        // إنشاء بطاقة للفئة
                        const traitCard = document.createElement('div');
                        traitCard.className = 'trait-card';
                        traitCard.setAttribute('data-aos', 'fade-up');
                        traitCard.setAttribute('data-aos-delay', categoryIndex * 150);

                        let iconClass, cardTitle;
                        switch (category) {
                            case 'A':
                                iconClass = 'fas fa-brain';
                                cardTitle = 'السمات المنطقية التحليلية';
                                break;
                            case 'B':
                                iconClass = 'fas fa-tasks';
                                cardTitle = 'السمات المنظمة التنفيذية';
                                break;
                            case 'C':
                                iconClass = 'fas fa-heart';
                                cardTitle = 'السمات العاطفية الاجتماعية';
                                break;
                            case 'D':
                                iconClass = 'fas fa-lightbulb';
                                cardTitle = 'السمات الابتكارية الاستراتيجية';
                                break;
                        }

                        // إنشاء هيكل البطاقة
                        let traitListHTML = '';
                        categoryTraits.forEach(trait => {
                            traitListHTML += `
                        <div class="trait-list-item">
                            <div class="trait-list-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span>${trait}</span>
                        </div>
                    `;
                        });

                        traitCard.innerHTML = `
                    <div class="trait-card-header">
                        <div class="trait-card-icon">
                            <i class="${iconClass}"></i>
                        </div>
                        <h4 class="trait-card-title">${cardTitle}</h4>
                    </div>
                    <div class="trait-card-body">
                        ${traitListHTML}
                    </div>
                `;

                        traitsList.appendChild(traitCard);
                    }
                });

                // تطبيق الحركات
                setTimeout(() => {
                    const traitCards = document.querySelectorAll('.trait-card');
                    traitCards.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('animate__animated', 'animate__fadeInUp');
                            setTimeout(() => {
                                card.classList.remove('animate__animated', 'animate__fadeInUp');
                            }, 1000);
                        }, index * 150);
                    });
                }, 500);
            }

            // مشاركة النتائج
            shareResults() {
                // إنشاء نص المشاركة
                const userName = this.userState.personalInfo.name || 'مستخدم';
                const dominantProfile = this.getDominantProfileName();
                const shareText = `نتائج اختبار توازن للشخصية لـ ${userName}:

النمط السائد: ${dominantProfile} (${this.userState.results[this.userState.dominantCategory]}%)

المنطقي التحليلي (A): ${this.userState.results.A}%
المنظم التنفيذي (B): ${this.userState.results.B}%
العاطفي الاجتماعي (C): ${this.userState.results.C}%
الابتكاري الاستراتيجي (D): ${this.userState.results.D}%

قم بإجراء الاختبار على: [رابط الموقع]`;

                // إذا كان API المشاركة متاحًا
                if (navigator.share) {
                    navigator.share({
                            title: 'نتائج اختبار توازن للشخصية',
                            text: shareText
                        })
                        .then(() => {
                            this.showAlert('تمت المشاركة بنجاح', 'success');
                        })
                        .catch((error) => {
                            console.error('Error sharing:', error);
                            this.copyToClipboard(shareText);
                        });
                } else {
                    // النسخ إلى الحافظة كخطة بديلة
                    this.copyToClipboard(shareText);
                }
            }

            // نسخ النص إلى الحافظة
            copyToClipboard(text) {
                // إنشاء حقل نصي مؤقت
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();

                try {
                    const successful = document.execCommand('copy');
                    const msg = successful ?
                        'تم نسخ النتائج إلى الحافظة. يمكنك لصقها في أي مكان للمشاركة.' :
                        'فشل نسخ النتائج';
                    this.showAlert(msg, successful ? 'success' : 'error');
                } catch (err) {
                    this.showAlert('فشل نسخ النتائج', 'error');
                    console.error('Error copying to clipboard:', err);
                }

                document.body.removeChild(textArea);
            }

            // إعادة الاختبار
            restartTest() {
                // تأكيد إعادة التشغيل
                if (confirm('هل أنت متأكد من رغبتك في إعادة الاختبار؟ سيتم فقدان نتائجك الحالية.')) {
                    // إعادة تعيين حالة المستخدم
                    this.resetUserState();

                    // تأثير الانتقال
                    this.elements.resultsContainer.classList.add('animate__animated', 'animate__fadeOut');

                    setTimeout(() => {
                        // إخفاء حاوية النتائج
                        this.elements.resultsContainer.style.display = 'none';

                        // عرض نموذج التسجيل
                        this.elements.registrationForm.style.display = 'block';
                        this.elements.registrationForm.classList.add('animate__animated', 'animate__fadeIn');

                        // تنظيف الحركات
                        this.elements.resultsContainer.classList.remove('animate__animated', 'animate__fadeOut');

                        setTimeout(() => {
                            this.elements.registrationForm.classList.remove('animate__animated', 'animate__fadeIn');
                        }, 500);

                        // إعادة تعيين حقول النموذج
                        this.elements.fullName.value = '';
                        this.elements.phone.value = '';
                        this.elements.email.value = '';
                        document.getElementById('male').checked = true;

                        // إعادة تعيين حاوية الاختبار
                        this.elements.testContainer.classList.remove('fade-in');

                        // إعادة تعيين التقدم
                        if (this.elements.progressBar && this.elements.progressText) {
                            this.elements.progressBar.style.width = '0%';
                            this.elements.progressText.textContent = '0%';
                        }

                        // إعادة تعيين الخطوات
                        this.updateSteps(1);

                        // التمرير إلى الأعلى
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }, 500);
                }
            }

            // فتح استشارة واتساب
            openConsultation() {
                // الحصول على تفاصيل المستخدم للرسالة
                const userName = this.userState.personalInfo.name || 'العميل';
                const dominantProfile = this.getDominantProfileName();

                // عرض مربع حوار تأكيد
                if (confirm('سيتم تحويلك إلى WhatsApp للتواصل مع خبير تحليل الشخصية. هل تريد المتابعة؟')) {
                    // إنشاء رسالة واتساب
                    const phone = '+966550005969'; // رقم الواتساب الخاص بك
                    const message = `مرحباً، أنا ${userName}، أريد الحصول على استشارة متخصصة بخصوص نتائج اختبار توازن للشخصية.\n\nالنمط السائد لدي هو: ${dominantProfile} (${this.userState.results[this.userState.dominantCategory]}%)\n\nنتائج الاختبار:\nA: ${this.userState.results.A}%\nB: ${this.userState.results.B}%\nC: ${this.userState.results.C}%\nD: ${this.userState.results.D}%`;

                    const whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                    window.open(whatsappUrl, '_blank');
                }
            }

            // الحصول على اسم النمط السائد
            getDominantProfileName() {
                switch (this.userState.dominantCategory) {
                    case 'A':
                        return 'المنطقي التحليلي';
                    case 'B':
                        return 'المنظم التنفيذي';
                    case 'C':
                        return 'العاطفي الاجتماعي';
                    case 'D':
                        return 'الابتكاري الاستراتيجي';
                    default:
                        return '';
                }
            }

            // عرض التنبيه
            showAlert(message, type = 'info') {
                // إزالة التنبيهات الموجودة
                const existingAlerts = document.querySelectorAll('.alert');
                existingAlerts.forEach(alert => {
                    alert.classList.remove('show');
                    setTimeout(() => {
                        if (document.body.contains(alert)) {
                            document.body.removeChild(alert);
                        }
                    }, 300);
                });

                // تعيين الأيقونة حسب النوع
                let iconClass = '';
                let title = '';

                switch (type) {
                    case 'success':
                        iconClass = 'fas fa-check-circle';
                        title = 'نجاح';
                        break;
                    case 'error':
                        iconClass = 'fas fa-exclamation-circle';
                        title = 'خطأ';
                        break;
                    default:
                        iconClass = 'fas fa-info-circle';
                        title = 'معلومات';
                }

                // إنشاء عنصر التنبيه
                const alert = document.createElement('div');
                alert.className = `alert alert-${type}`;

                alert.innerHTML = `
            <div class="alert-icon">
                <i class="${iconClass}"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <div>${message}</div>
            </div>
            <button class="alert-close">
                <i class="fas fa-times"></i>
            </button>
        `;

                // إضافة التنبيه إلى المستند
                document.body.appendChild(alert);

                // عرض التنبيه مع الحركة
                setTimeout(() => {
                    alert.classList.add('show', 'animate__animated', 'animate__bounceInRight');

                    setTimeout(() => {
                        alert.classList.remove('animate__animated', 'animate__bounceInRight');
                    }, 1000);
                }, 10);

                // إضافة حدث زر الإغلاق
                alert.querySelector('.alert-close').addEventListener('click', () => {
                    this.closeAlert(alert);
                });

                // إغلاق تلقائي بعد 5 ثوانٍ
                setTimeout(() => {
                    this.closeAlert(alert);
                }, 5000);
            }

            // إغلاق التنبيه مع الحركة
            closeAlert(alert) {
                if (!document.body.contains(alert)) return;

                alert.classList.add('animate__animated', 'animate__bounceOutRight');

                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => {
                        if (document.body.contains(alert)) {
                            document.body.removeChild(alert);
                        }
                    }, 300);
                }, 500);
            }

            // دالة مساعدة لخلط المصفوفة
            shuffleArray(array) {
                const newArray = [...array];
                for (let i = newArray.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
                }
                return newArray;
            }
        }

        // إضافة طريقة عرض رسالة التحميل للكلاس
        PersonalityTest.prototype.showLoadingMessage = function(message) {
            const loadingText = document.getElementById('loadingText');
            if (loadingText) {
                // تلاشي النص الحالي
                loadingText.classList.add('animate__animated', 'animate__fadeOut');

                // تحديث النص والظهور
                setTimeout(() => {
                    loadingText.textContent = message;
                    loadingText.classList.remove('animate__fadeOut');
                    loadingText.classList.add('animate__fadeIn');

                    // إزالة فئات الحركة
                    setTimeout(() => {
                        loadingText.classList.remove('animate__animated', 'animate__fadeIn');
                    }, 500);
                }, 300);
            }
        };

        // تهيئة اختبار الشخصية عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            // إنشاء كائن اختبار الشخصية
            const personalityTest = new PersonalityTest();

            // ننتظر فترة قصيرة لضمان تحميل جميع العناصر
            setTimeout(() => {
                // تهيئة العناصر
                personalityTest.initializeElements();

                // عرض رسائل التحميل
                personalityTest.showLoadingMessage('جاري تحميل الاختبار...');

                setTimeout(() => {
                    personalityTest.showLoadingMessage('تجهيز أسئلة الاختبار...');

                    setTimeout(() => {
                        personalityTest.showLoadingMessage('جاري تهيئة الصفحة...');

                        // إخفاء شاشة التحميل بعد الانتهاء
                        setTimeout(() => {
                            personalityTest.elements.loadingOverlay.style.opacity = '0';
                            setTimeout(() => {
                                personalityTest.elements.loadingOverlay.style.display = 'none';
                            }, 500);
                        }, 800);
                    }, 800);
                }, 800);
            }, 100);
        });
    </script>
</body>

</html>
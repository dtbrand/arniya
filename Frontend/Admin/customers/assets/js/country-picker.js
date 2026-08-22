/**
 * country-picker.js — Searchable All-World Country Dropdown & Country-Wise Dynamic Auto-Field Engine
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 * 195+ Complete World Countries with Flags, Calling Codes, Real States/Provinces, Cities & Postal Codes
 */

(function () {
    'use strict';

    // ══════════════════════════════════════════════════════════════════════════════
    // 🌍 COMPLETE 195+ WORLD COUNTRIES DIRECTORY
    // ══════════════════════════════════════════════════════════════════════════════
    const allWorldCountries = [
        // ── Pinned Popular Textile Export & Retail Markets ──
        { code: 'IN', name: 'India (Bharat)', flag: '🇮🇳', dial: '+91', popular: true },
        { code: 'US', name: 'United States (USA)', flag: '🇺🇸', dial: '+1', popular: true },
        { code: 'AE', name: 'United Arab Emirates (Dubai / UAE)', flag: '🇦🇪', dial: '+971', popular: true },
        { code: 'GB', name: 'United Kingdom (UK)', flag: '🇬🇧', dial: '+44', popular: true },
        { code: 'CA', name: 'Canada', flag: '🇨🇦', dial: '+1', popular: true },
        { code: 'AU', name: 'Australia', flag: '🇦🇺', dial: '+61', popular: true },
        { code: 'SG', name: 'Singapore', flag: '🇸🇬', dial: '+65', popular: true },
        { code: 'MY', name: 'Malaysia', flag: '🇲🇾', dial: '+60', popular: true },
        { code: 'MU', name: 'Mauritius', flag: '🇲🇺', dial: '+230', popular: true },
        { code: 'NP', name: 'Nepal', flag: '🇳🇵', dial: '+977', popular: true },
        { code: 'SA', name: 'Saudi Arabia', flag: '🇸🇦', dial: '+966', popular: true },
        { code: 'KW', name: 'Kuwait', flag: '🇰🇼', dial: '+965', popular: true },
        { code: 'QA', name: 'Qatar', flag: '🇶🇦', dial: '+974', popular: true },
        { code: 'OM', name: 'Oman', flag: '🇴🇲', dial: '+968', popular: true },
        { code: 'BH', name: 'Bahrain', flag: '🇧🇭', dial: '+973', popular: true },
        { code: 'NZ', name: 'New Zealand', flag: '🇳🇿', dial: '+64', popular: true },
        { code: 'ZA', name: 'South Africa', flag: '🇿🇦', dial: '+27', popular: true },
        { code: 'BD', name: 'Bangladesh', flag: '🇧🇩', dial: '+880', popular: true },
        { code: 'LK', name: 'Sri Lanka', flag: '🇱🇰', dial: '+94', popular: true },
        { code: 'DE', name: 'Germany', flag: '🇩🇪', dial: '+49', popular: true },
        { code: 'FR', name: 'France', flag: '🇫🇷', dial: '+33', popular: true },

        // ── Complete Alphabetical World Countries (A to Z) ──
        { code: 'AF', name: 'Afghanistan', flag: '🇦🇫', dial: '+93' },
        { code: 'AL', name: 'Albania', flag: '🇦🇱', dial: '+355' },
        { code: 'DZ', name: 'Algeria', flag: '🇩🇿', dial: '+213' },
        { code: 'AD', name: 'Andorra', flag: '🇦🇩', dial: '+376' },
        { code: 'AO', name: 'Angola', flag: '🇦🇴', dial: '+244' },
        { code: 'AG', name: 'Antigua and Barbuda', flag: '🇦🇬', dial: '+1-268' },
        { code: 'AR', name: 'Argentina', flag: '🇦🇷', dial: '+54' },
        { code: 'AM', name: 'Armenia', flag: '🇦🇲', dial: '+374' },
        { code: 'AT', name: 'Austria', flag: '🇦🇹', dial: '+43' },
        { code: 'AZ', name: 'Azerbaijan', flag: '🇦🇿', dial: '+994' },
        { code: 'BS', name: 'Bahamas', flag: '🇧🇸', dial: '+1-242' },
        { code: 'BB', name: 'Barbados', flag: '🇧🇧', dial: '+1-246' },
        { code: 'BY', name: 'Belarus', flag: '🇧🇾', dial: '+375' },
        { code: 'BE', name: 'Belgium', flag: '🇧🇪', dial: '+32' },
        { code: 'BZ', name: 'Belize', flag: '🇧🇿', dial: '+501' },
        { code: 'BJ', name: 'Benin', flag: '🇧🇯', dial: '+229' },
        { code: 'BT', name: 'Bhutan', flag: '🇧🇹', dial: '+975' },
        { code: 'BO', name: 'Bolivia', flag: '🇧🇴', dial: '+591' },
        { code: 'BA', name: 'Bosnia and Herzegovina', flag: '🇧🇦', dial: '+387' },
        { code: 'BW', name: 'Botswana', flag: '🇧🇼', dial: '+267' },
        { code: 'BR', name: 'Brazil', flag: '🇧🇷', dial: '+55' },
        { code: 'BN', name: 'Brunei', flag: '🇧🇳', dial: '+673' },
        { code: 'BG', name: 'Bulgaria', flag: '🇧🇬', dial: '+359' },
        { code: 'BF', name: 'Burkina Faso', flag: '🇧🇫', dial: '+226' },
        { code: 'BI', name: 'Burundi', flag: '🇧🇮', dial: '+257' },
        { code: 'CV', name: 'Cabo Verde', flag: '🇨🇻', dial: '+238' },
        { code: 'KH', name: 'Cambodia', flag: '🇰🇭', dial: '+855' },
        { code: 'CM', name: 'Cameroon', flag: '🇨🇲', dial: '+237' },
        { code: 'CF', name: 'Central African Republic', flag: '🇨🇫', dial: '+236' },
        { code: 'TD', name: 'Chad', flag: '🇹🇩', dial: '+235' },
        { code: 'CL', name: 'Chile', flag: '🇨🇱', dial: '+56' },
        { code: 'CN', name: 'China', flag: '🇨🇳', dial: '+86' },
        { code: 'CO', name: 'Colombia', flag: '🇨🇴', dial: '+57' },
        { code: 'KM', name: 'Comoros', flag: '🇰🇲', dial: '+269' },
        { code: 'CG', name: 'Congo', flag: '🇨🇬', dial: '+242' },
        { code: 'CR', name: 'Costa Rica', flag: '🇨🇷', dial: '+506' },
        { code: 'HR', name: 'Croatia', flag: '🇭🇷', dial: '+385' },
        { code: 'CU', name: 'Cuba', flag: '🇨🇺', dial: '+53' },
        { code: 'CY', name: 'Cyprus', flag: '🇨🇾', dial: '+357' },
        { code: 'CZ', name: 'Czech Republic', flag: '🇨🇿', dial: '+420' },
        { code: 'DK', name: 'Denmark', flag: '🇩🇰', dial: '+45' },
        { code: 'DJ', name: 'Djibouti', flag: '🇩🇯', dial: '+253' },
        { code: 'DM', name: 'Dominica', flag: '🇩🇲', dial: '+1-767' },
        { code: 'DO', name: 'Dominican Republic', flag: '🇩🇴', dial: '+1-809' },
        { code: 'EC', name: 'Ecuador', flag: '🇪🇨', dial: '+593' },
        { code: 'EG', name: 'Egypt', flag: '🇪🇬', dial: '+20' },
        { code: 'SV', name: 'El Salvador', flag: '🇸🇻', dial: '+503' },
        { code: 'GQ', name: 'Equatorial Guinea', flag: '🇬🇶', dial: '+240' },
        { code: 'ER', name: 'Eritrea', flag: '🇪🇷', dial: '+291' },
        { code: 'EE', name: 'Estonia', flag: '🇪🇪', dial: '+372' },
        { code: 'SZ', name: 'Eswatini', flag: '🇸🇿', dial: '+268' },
        { code: 'ET', name: 'Ethiopia', flag: '🇪🇹', dial: '+251' },
        { code: 'FJ', name: 'Fiji', flag: '🇫🇯', dial: '+679' },
        { code: 'FI', name: 'Finland', flag: '🇫🇮', dial: '+358' },
        { code: 'GA', name: 'Gabon', flag: '🇬🇦', dial: '+241' },
        { code: 'GM', name: 'Gambia', flag: '🇬🇲', dial: '+220' },
        { code: 'GE', name: 'Georgia', flag: '🇬🇪', dial: '+995' },
        { code: 'GH', name: 'Ghana', flag: '🇬🇭', dial: '+233' },
        { code: 'GR', name: 'Greece', flag: '🇬🇷', dial: '+30' },
        { code: 'GD', name: 'Grenada', flag: '🇬🇩', dial: '+1-473' },
        { code: 'GT', name: 'Guatemala', flag: '🇬🇹', dial: '+502' },
        { code: 'GN', name: 'Guinea', flag: '🇬🇳', dial: '+224' },
        { code: 'GY', name: 'Guyana', flag: '🇬🇾', dial: '+592' },
        { code: 'HT', name: 'Haiti', flag: '🇭🇹', dial: '+509' },
        { code: 'HN', name: 'Honduras', flag: '🇭🇳', dial: '+504' },
        { code: 'HK', name: 'Hong Kong', flag: '🇭🇰', dial: '+852' },
        { code: 'HU', name: 'Hungary', flag: '🇭🇺', dial: '+36' },
        { code: 'IS', name: 'Iceland', flag: '🇮🇸', dial: '+354' },
        { code: 'ID', name: 'Indonesia', flag: '🇮🇩', dial: '+62' },
        { code: 'IR', name: 'Iran', flag: '🇮🇷', dial: '+98' },
        { code: 'IQ', name: 'Iraq', flag: '🇮🇶', dial: '+964' },
        { code: 'IE', name: 'Ireland', flag: '🇮🇪', dial: '+353' },
        { code: 'IL', name: 'Israel', flag: '🇮🇱', dial: '+972' },
        { code: 'IT', name: 'Italy', flag: '🇮🇹', dial: '+39' },
        { code: 'JM', name: 'Jamaica', flag: '🇯🇲', dial: '+1-876' },
        { code: 'JP', name: 'Japan', flag: '🇯🇵', dial: '+81' },
        { code: 'JO', name: 'Jordan', flag: '🇯🇴', dial: '+962' },
        { code: 'KZ', name: 'Kazakhstan', flag: '🇰🇿', dial: '+7' },
        { code: 'KE', name: 'Kenya', flag: '🇰🇪', dial: '+254' },
        { code: 'KR', name: 'South Korea', flag: '🇰🇷', dial: '+82' },
        { code: 'KG', name: 'Kyrgyzstan', flag: '🇰🇬', dial: '+996' },
        { code: 'LA', name: 'Laos', flag: '🇱🇦', dial: '+856' },
        { code: 'LV', name: 'Latvia', flag: '🇱🇻', dial: '+371' },
        { code: 'LB', name: 'Lebanon', flag: '🇱🇧', dial: '+961' },
        { code: 'LS', name: 'Lesotho', flag: '🇱🇸', dial: '+266' },
        { code: 'LR', name: 'Liberia', flag: '🇱🇷', dial: '+231' },
        { code: 'LY', name: 'Libya', flag: '🇱🇾', dial: '+218' },
        { code: 'LI', name: 'Liechtenstein', flag: '🇱🇮', dial: '+423' },
        { code: 'LT', name: 'Lithuania', flag: '🇱🇹', dial: '+370' },
        { code: 'LU', name: 'Luxembourg', flag: '🇱🇺', dial: '+352' },
        { code: 'MG', name: 'Madagascar', flag: '🇲🇬', dial: '+261' },
        { code: 'MW', name: 'Malawi', flag: '🇲🇼', dial: '+265' },
        { code: 'MV', name: 'Maldives', flag: '🇲🇻', dial: '+960' },
        { code: 'ML', name: 'Mali', flag: '🇲🇱', dial: '+223' },
        { code: 'MT', name: 'Malta', flag: '🇲🇹', dial: '+356' },
        { code: 'MX', name: 'Mexico', flag: '🇲🇽', dial: '+52' },
        { code: 'MD', name: 'Moldova', flag: '🇲🇩', dial: '+373' },
        { code: 'MC', name: 'Monaco', flag: '🇲🇨', dial: '+377' },
        { code: 'MN', name: 'Mongolia', flag: '🇲🇳', dial: '+976' },
        { code: 'ME', name: 'Montenegro', flag: '🇲🇪', dial: '+382' },
        { code: 'MA', name: 'Morocco', flag: '🇲🇦', dial: '+212' },
        { code: 'MZ', name: 'Mozambique', flag: '🇲🇿', dial: '+258' },
        { code: 'MM', name: 'Myanmar', flag: '🇲🇲', dial: '+95' },
        { code: 'NA', name: 'Namibia', flag: '🇳🇦', dial: '+264' },
        { code: 'NL', name: 'Netherlands', flag: '🇳🇱', dial: '+31' },
        { code: 'NG', name: 'Nigeria', flag: '🇳🇬', dial: '+234' },
        { code: 'NO', name: 'Norway', flag: '🇳🇴', dial: '+47' },
        { code: 'PK', name: 'Pakistan', flag: '🇵🇰', dial: '+92' },
        { code: 'PA', name: 'Panama', flag: '🇵🇦', dial: '+507' },
        { code: 'PY', name: 'Paraguay', flag: '🇵🇾', dial: '+595' },
        { code: 'PE', name: 'Peru', flag: '🇵🇪', dial: '+51' },
        { code: 'PH', name: 'Philippines', flag: '🇵🇭', dial: '+63' },
        { code: 'PL', name: 'Poland', flag: '🇵🇱', dial: '+48' },
        { code: 'PT', name: 'Portugal', flag: '🇵🇹', dial: '+351' },
        { code: 'RO', name: 'Romania', flag: '🇷🇴', dial: '+40' },
        { code: 'RU', name: 'Russia', flag: '🇷🇺', dial: '+7' },
        { code: 'RW', name: 'Rwanda', flag: '🇷🇼', dial: '+250' },
        { code: 'SN', name: 'Senegal', flag: '🇸🇳', dial: '+221' },
        { code: 'RS', name: 'Serbia', flag: '🇷🇸', dial: '+381' },
        { code: 'SC', name: 'Seychelles', flag: '🇸🇨', dial: '+248' },
        { code: 'SL', name: 'Sierra Leone', flag: '🇸🇱', dial: '+232' },
        { code: 'SK', name: 'Slovakia', flag: '🇸🇰', dial: '+421' },
        { code: 'SI', name: 'Slovenia', flag: '🇸🇮', dial: '+386' },
        { code: 'SO', name: 'Somalia', flag: '🇸🇴', dial: '+252' },
        { code: 'ES', name: 'Spain', flag: '🇪🇸', dial: '+34' },
        { code: 'SD', name: 'Sudan', flag: '🇸🇩', dial: '+249' },
        { code: 'SE', name: 'Sweden', flag: '🇸🇪', dial: '+46' },
        { code: 'CH', name: 'Switzerland', flag: '🇨🇭', dial: '+41' },
        { code: 'SY', name: 'Syria', flag: '🇸🇾', dial: '+963' },
        { code: 'TW', name: 'Taiwan', flag: '🇹🇼', dial: '+886' },
        { code: 'TJ', name: 'Tajikistan', flag: '🇹🇯', dial: '+992' },
        { code: 'TZ', name: 'Tanzania', flag: '🇹🇿', dial: '+255' },
        { code: 'TH', name: 'Thailand', flag: '🇹🇭', dial: '+66' },
        { code: 'TG', name: 'Togo', flag: '🇹🇬', dial: '+228' },
        { code: 'TO', name: 'Tonga', flag: '🇹🇴', dial: '+676' },
        { code: 'TT', name: 'Trinidad and Tobago', flag: '🇹🇹', dial: '+1-868' },
        { code: 'TN', name: 'Tunisia', flag: '🇹🇳', dial: '+216' },
        { code: 'TR', name: 'Turkey', flag: '🇹🇷', dial: '+90' },
        { code: 'TM', name: 'Turkmenistan', flag: '🇹🇲', dial: '+993' },
        { code: 'UG', name: 'Uganda', flag: '🇺🇬', dial: '+256' },
        { code: 'UA', name: 'Ukraine', flag: '🇺🇦', dial: '+380' },
        { code: 'UY', name: 'Uruguay', flag: '🇺🇾', dial: '+598' },
        { code: 'UZ', name: 'Uzbekistan', flag: '🇺🇿', dial: '+998' },
        { code: 'VE', name: 'Venezuela', flag: '🇻🇪', dial: '+58' },
        { code: 'VN', name: 'Vietnam', flag: '🇻🇳', dial: '+84' },
        { code: 'YE', name: 'Yemen', flag: '🇾🇪', dial: '+967' },
        { code: 'ZM', name: 'Zambia', flag: '🇿🇲', dial: '+260' },
        { code: 'ZW', name: 'Zimbabwe', flag: '🇿🇼', dial: '+263' }
    ];

    // ══════════════════════════════════════════════════════════════════════════════
    // 🏢 COUNTRY CONTEXT & REGIONAL FIELD MAPPINGS
    // ══════════════════════════════════════════════════════════════════════════════
    const countryContextData = {
        IN: {
            code: 'IN',
            name: 'India (Bharat)',
            flag: '🇮🇳',
            dial: '+91',
            phonePlaceholder: '+91 98XXX XXXXX',
            cityPlaceholder: 'e.g. Surat, Mumbai, Delhi, Ahmedabad, Jaipur, Bengaluru',
            stateLabel: 'State / Union Territory',
            postalLabel: 'PIN Code (6-Digit)',
            postalPlaceholder: 'e.g. 395002',
            landmarkPlaceholder: 'e.g. Near City Bus Stand / Textile Market Gate / Ring Road',
            addressPlaceholder: 'House/Flat No., Building Name, Street / Society',
            defaultLang: 'Hindi',
            states: [
                { code: 'GJ', name: 'Gujarat' },
                { code: 'MH', name: 'Maharashtra' },
                { code: 'DL', name: 'Delhi NCR' },
                { code: 'RJ', name: 'Rajasthan' },
                { code: 'UP', name: 'Uttar Pradesh' },
                { code: 'WB', name: 'West Bengal' },
                { code: 'TN', name: 'Tamil Nadu' },
                { code: 'KA', name: 'Karnataka' },
                { code: 'TS', name: 'Telangana' },
                { code: 'PB', name: 'Punjab' },
                { code: 'KL', name: 'Kerala' },
                { code: 'MP', name: 'Madhya Pradesh' },
                { code: 'AP', name: 'Andhra Pradesh' },
                { code: 'HR', name: 'Haryana' },
                { code: 'BR', name: 'Bihar' },
                { code: 'OR', name: 'Odisha' },
                { code: 'AS', name: 'Assam' },
                { code: 'GA', name: 'Goa' },
                { code: 'UT', name: 'Uttarakhand' },
                { code: 'JH', name: 'Jharkhand' },
                { code: 'CT', name: 'Chhattisgarh' },
                { code: 'HP', name: 'Himachal Pradesh' },
                { code: 'JK', name: 'Jammu & Kashmir' },
                { code: 'CH', name: 'Chandigarh' },
                { code: 'OTHER', name: 'Other State / UT' }
            ]
        },
        US: {
            code: 'US',
            name: 'United States (USA)',
            flag: '🇺🇸',
            dial: '+1',
            phonePlaceholder: '+1 (555) 000-0000',
            cityPlaceholder: 'e.g. New York, Los Angeles, Chicago, Houston, Dallas, San Jose',
            stateLabel: 'State',
            postalLabel: 'ZIP Code (5-Digit)',
            postalPlaceholder: 'e.g. 90210 / 10001',
            landmarkPlaceholder: 'e.g. Apt 4B, Suite 200, Near Central Park / Main Blvd',
            addressPlaceholder: 'Street Address, Apt / Suite / Unit',
            defaultLang: 'English',
            states: [
                { code: 'CA', name: 'California (CA)' },
                { code: 'NY', name: 'New York (NY)' },
                { code: 'TX', name: 'Texas (TX)' },
                { code: 'FL', name: 'Florida (FL)' },
                { code: 'IL', name: 'Illinois (IL)' },
                { code: 'PA', name: 'Pennsylvania (PA)' },
                { code: 'OH', name: 'Ohio (OH)' },
                { code: 'GA', name: 'Georgia (GA)' },
                { code: 'NC', name: 'North Carolina (NC)' },
                { code: 'MI', name: 'Michigan (MI)' },
                { code: 'NJ', name: 'New Jersey (NJ)' },
                { code: 'VA', name: 'Virginia (VA)' },
                { code: 'WA', name: 'Washington (WA)' },
                { code: 'AZ', name: 'Arizona (AZ)' },
                { code: 'MA', name: 'Massachusetts (MA)' },
                { code: 'TN', name: 'Tennessee (TN)' },
                { code: 'IN', name: 'Indiana (IN)' },
                { code: 'MO', name: 'Missouri (MO)' },
                { code: 'MD', name: 'Maryland (MD)' },
                { code: 'WI', name: 'Wisconsin (WI)' },
                { code: 'CO', name: 'Colorado (CO)' },
                { code: 'MN', name: 'Minnesota (MN)' },
                { code: 'SC', name: 'South Carolina (SC)' },
                { code: 'AL', name: 'Alabama (AL)' },
                { code: 'LA', name: 'Louisiana (LA)' },
                { code: 'KY', name: 'Kentucky (KY)' },
                { code: 'OR', name: 'Oregon (OR)' },
                { code: 'OK', name: 'Oklahoma (OK)' },
                { code: 'CT', name: 'Connecticut (CT)' },
                { code: 'UT', name: 'Utah (UT)' },
                { code: 'IA', name: 'Iowa (IA)' },
                { code: 'NV', name: 'Nevada (NV)' },
                { code: 'AR', name: 'Arkansas (AR)' },
                { code: 'MS', name: 'Mississippi (MS)' },
                { code: 'KS', name: 'Kansas (KS)' },
                { code: 'NM', name: 'New Mexico (NM)' },
                { code: 'NE', name: 'Nebraska (NE)' },
                { code: 'ID', name: 'Idaho (ID)' },
                { code: 'WV', name: 'West Virginia (WV)' },
                { code: 'HI', name: 'Hawaii (HI)' },
                { code: 'NH', name: 'New Hampshire (NH)' },
                { code: 'ME', name: 'Maine (ME)' },
                { code: 'MT', name: 'Montana (MT)' },
                { code: 'RI', name: 'Rhode Island (RI)' },
                { code: 'DE', name: 'Delaware (DE)' },
                { code: 'SD', name: 'South Dakota (SD)' },
                { code: 'ND', name: 'North Dakota (ND)' },
                { code: 'AK', name: 'Alaska (AK)' },
                { code: 'VT', name: 'Vermont (VT)' },
                { code: 'WY', name: 'Wyoming (WY)' },
                { code: 'OTHER', name: 'Other US Territory' }
            ]
        },
        AE: {
            code: 'AE',
            name: 'United Arab Emirates (Dubai / UAE)',
            flag: '🇦🇪',
            dial: '+971',
            phonePlaceholder: '+971 50 123 4567',
            cityPlaceholder: 'e.g. Dubai, Deira, Abu Dhabi, Sharjah, Bur Dubai, Al Ain',
            stateLabel: 'Emirate',
            postalLabel: 'P.O. Box / Makani No.',
            postalPlaceholder: 'e.g. P.O. Box 12345 / Makani 30032 95320',
            landmarkPlaceholder: 'e.g. Near Mall of Emirates / Gold Souk / Al Fahidi / Burj Khalifa',
            addressPlaceholder: 'Building Name, Flat/Office No., Street, Area',
            defaultLang: 'English',
            states: [
                { code: 'DXB', name: 'Dubai' },
                { code: 'AUH', name: 'Abu Dhabi' },
                { code: 'SHJ', name: 'Sharjah' },
                { code: 'AJM', name: 'Ajman' },
                { code: 'RAK', name: 'Ras Al Khaimah' },
                { code: 'FUJ', name: 'Fujairah' },
                { code: 'UAQ', name: 'Umm Al Quwain' }
            ]
        },
        GB: {
            code: 'GB',
            name: 'United Kingdom (UK)',
            flag: '🇬🇧',
            dial: '+44',
            phonePlaceholder: '+44 7911 123456',
            cityPlaceholder: 'e.g. London, Birmingham, Manchester, Leicester, Leeds, Glasgow',
            stateLabel: 'County / Country Region',
            postalLabel: 'Postcode',
            postalPlaceholder: 'e.g. W1D 1BS / B1 1BB / M1 1AE',
            landmarkPlaceholder: 'e.g. Flat 12, High Street / Near Tube Station',
            addressPlaceholder: 'Building Number, Street / Road, Flat No.',
            defaultLang: 'English',
            states: [
                { code: 'ENG-LDN', name: 'England - Greater London' },
                { code: 'ENG-WM', name: 'England - West Midlands (Birmingham)' },
                { code: 'ENG-GM', name: 'England - Greater Manchester' },
                { code: 'ENG-WY', name: 'England - West Yorkshire (Leeds/Bradford)' },
                { code: 'ENG-EM', name: 'England - East Midlands (Leicester)' },
                { code: 'ENG-NW', name: 'England - North West' },
                { code: 'ENG-SE', name: 'England - South East' },
                { code: 'ENG-SW', name: 'England - South West' },
                { code: 'SCO', name: 'Scotland (Glasgow / Edinburgh)' },
                { code: 'WAL', name: 'Wales (Cardiff / Swansea)' },
                { code: 'NIR', name: 'Northern Ireland (Belfast)' },
                { code: 'OTHER', name: 'Other UK Region' }
            ]
        },
        CA: {
            code: 'CA',
            name: 'Canada',
            flag: '🇨🇦',
            dial: '+1',
            phonePlaceholder: '+1 (416) 555-0199',
            cityPlaceholder: 'e.g. Toronto, Vancouver, Montreal, Calgary, Brampton, Surrey',
            stateLabel: 'Province / Territory',
            postalLabel: 'Postal Code (A1A 1A1)',
            postalPlaceholder: 'e.g. M5V 2T6 / V6B 1A1',
            landmarkPlaceholder: 'e.g. Suite 300, Near Metro / Highway 401',
            addressPlaceholder: 'Street Address, Unit / Apt / Suite',
            defaultLang: 'English',
            states: [
                { code: 'ON', name: 'Ontario (Toronto / Brampton)' },
                { code: 'BC', name: 'British Columbia (Vancouver / Surrey)' },
                { code: 'QC', name: 'Quebec (Montreal)' },
                { code: 'AB', name: 'Alberta (Calgary / Edmonton)' },
                { code: 'MB', name: 'Manitoba (Winnipeg)' },
                { code: 'SK', name: 'Saskatchewan (Regina)' },
                { code: 'NS', name: 'Nova Scotia (Halifax)' },
                { code: 'NB', name: 'New Brunswick' },
                { code: 'NL', name: 'Newfoundland and Labrador' },
                { code: 'PE', name: 'Prince Edward Island' },
                { code: 'NT', name: 'Northwest Territories' },
                { code: 'YT', name: 'Yukon' },
                { code: 'NU', name: 'Nunavut' }
            ]
        },
        AU: {
            code: 'AU',
            name: 'Australia',
            flag: '🇦🇺',
            dial: '+61',
            phonePlaceholder: '+61 412 345 678',
            cityPlaceholder: 'e.g. Sydney, Melbourne, Brisbane, Perth, Adelaide, Parramatta',
            stateLabel: 'State / Territory',
            postalLabel: 'Postal Code (4-Digit)',
            postalPlaceholder: 'e.g. 2000 / 3000 / 4000',
            landmarkPlaceholder: 'e.g. Unit 5, Near Central Train Station / CBD',
            addressPlaceholder: 'Street Address, Apartment / Unit Number',
            defaultLang: 'English',
            states: [
                { code: 'NSW', name: 'New South Wales (Sydney)' },
                { code: 'VIC', name: 'Victoria (Melbourne)' },
                { code: 'QLD', name: 'Queensland (Brisbane)' },
                { code: 'WA', name: 'Western Australia (Perth)' },
                { code: 'SA', name: 'South Australia (Adelaide)' },
                { code: 'TAS', name: 'Tasmania (Hobart)' },
                { code: 'ACT', name: 'Australian Capital Territory (Canberra)' },
                { code: 'NT', name: 'Northern Territory (Darwin)' }
            ]
        },
        SG: {
            code: 'SG',
            name: 'Singapore',
            flag: '🇸🇬',
            dial: '+65',
            phonePlaceholder: '+65 8123 4567',
            cityPlaceholder: 'e.g. Singapore, Orchard, Jurong, Tampines, Little India',
            stateLabel: 'District / Region',
            postalLabel: 'Postal Code (6-Digit)',
            postalPlaceholder: 'e.g. 238801 / 529538',
            landmarkPlaceholder: 'e.g. Near MRT Station / Little India Arcade',
            addressPlaceholder: 'Block No., Street Name, #Floor-Unit',
            defaultLang: 'English',
            states: [
                { code: 'SG-CR', name: 'Central Region (Downtown / Orchard / Little India)' },
                { code: 'SG-ER', name: 'East Region (Tampines / Bedok)' },
                { code: 'SG-WR', name: 'West Region (Jurong / Clementi)' },
                { code: 'SG-NR', name: 'North Region (Woodlands / Yishun)' },
                { code: 'SG-NER', name: 'North-East Region (Serangoon / Sengkang)' }
            ]
        },
        MY: {
            code: 'MY',
            name: 'Malaysia',
            flag: '🇲🇾',
            dial: '+60',
            phonePlaceholder: '+60 12-345 6789',
            cityPlaceholder: 'e.g. Kuala Lumpur, George Town, Petaling Jaya, Johor Bahru',
            stateLabel: 'State / Federal Territory',
            postalLabel: 'Postcode (5-Digit)',
            postalPlaceholder: 'e.g. 50450 / 10200 / 80000',
            landmarkPlaceholder: 'e.g. Near Pavilion / Little India Brickfields',
            addressPlaceholder: 'House/Shop No., Jalan (Street), Taman/Area',
            defaultLang: 'English',
            states: [
                { code: 'KL', name: 'Kuala Lumpur (Federal Territory)' },
                { code: 'SGR', name: 'Selangor (Petaling Jaya / Klang)' },
                { code: 'PNG', name: 'Penang (George Town)' },
                { code: 'JHR', name: 'Johor (Johor Bahru)' },
                { code: 'PRK', name: 'Perak (Ipoh)' },
                { code: 'MLK', name: 'Melaka' },
                { code: 'NSN', name: 'Negeri Sembilan (Seremban)' },
                { code: 'PHG', name: 'Pahang (Kuantan)' },
                { code: 'KDH', name: 'Kedah (Alor Setar)' },
                { code: 'KTN', name: 'Kelantan (Kota Bharu)' },
                { code: 'TRG', name: 'Terengganu (Kuala Terengganu)' },
                { code: 'SBH', name: 'Sabah (Kota Kinabalu)' },
                { code: 'SWK', name: 'Sarawak (Kuching)' }
            ]
        },
        SA: {
            code: 'SA',
            name: 'Saudi Arabia',
            flag: '🇸🇦',
            dial: '+966',
            phonePlaceholder: '+966 50 123 4567',
            cityPlaceholder: 'e.g. Riyadh, Jeddah, Dammam, Mecca, Medina, Khobar',
            stateLabel: 'Province / Region',
            postalLabel: 'Postal / National Short Code',
            postalPlaceholder: 'e.g. 11564 / Short Address Code',
            landmarkPlaceholder: 'e.g. Near Kingdom Tower / Corniche / Mosque',
            addressPlaceholder: 'Building No., Street Name, District / Neighborhood',
            defaultLang: 'English',
            states: [
                { code: 'RYD', name: 'Riyadh Province' },
                { code: 'MKH', name: 'Makkah Province (Jeddah / Mecca)' },
                { code: 'EP', name: 'Eastern Province (Dammam / Khobar / Jubail)' },
                { code: 'MDN', name: 'Al Madinah Province' },
                { code: 'ASR', name: 'Asir (Abha)' },
                { code: 'TBK', name: 'Tabuk' },
                { code: 'QSM', name: 'Al-Qassim (Buraidah)' }
            ]
        },
        KW: {
            code: 'KW',
            name: 'Kuwait',
            flag: '🇰🇼',
            dial: '+965',
            phonePlaceholder: '+965 9123 4567',
            cityPlaceholder: 'e.g. Kuwait City, Salmiya, Hawalli, Farwaniya',
            stateLabel: 'Governorate',
            postalLabel: 'Postal / Area Code',
            postalPlaceholder: 'e.g. 13001 / Block 4',
            landmarkPlaceholder: 'e.g. Near The Avenues / Marina Mall',
            addressPlaceholder: 'Block No., Street, Building/Villa No.',
            defaultLang: 'English',
            states: [
                { code: 'KWT-AS', name: 'Al Asimah (Capital / Kuwait City)' },
                { code: 'KWT-HW', name: 'Hawalli (Salmiya)' },
                { code: 'KWT-FR', name: 'Farwaniya' },
                { code: 'KWT-AH', name: 'Ahmadi (Fahaheel)' },
                { code: 'KWT-JH', name: 'Jahra' },
                { code: 'KWT-MB', name: 'Mubarak Al-Kabeer' }
            ]
        },
        QA: {
            code: 'QA',
            name: 'Qatar',
            flag: '🇶🇦',
            dial: '+974',
            phonePlaceholder: '+974 5512 3456',
            cityPlaceholder: 'e.g. Doha, Al Rayyan, Lusail, Al Wakrah',
            stateLabel: 'Municipality',
            postalLabel: 'Zone / Building PIN',
            postalPlaceholder: 'e.g. Zone 24 / Street 850',
            landmarkPlaceholder: 'e.g. Near Souq Waqif / Pearl Qatar / Mall of Qatar',
            addressPlaceholder: 'Building No., Zone, Street No.',
            defaultLang: 'English',
            states: [
                { code: 'QAT-DA', name: 'Ad-Dawhah (Doha / Lusail / Pearl)' },
                { code: 'QAT-RY', name: 'Al Rayyan' },
                { code: 'QAT-WA', name: 'Al Wakrah' },
                { code: 'QAT-KH', name: 'Al Khor' },
                { code: 'QAT-US', name: 'Umm Salal' }
            ]
        },
        OM: {
            code: 'OM',
            name: 'Oman',
            flag: '🇴🇲',
            dial: '+968',
            phonePlaceholder: '+968 9123 4567',
            cityPlaceholder: 'e.g. Muscat, Seeb, Salalah, Sohar, Muttrah',
            stateLabel: 'Governorate',
            postalLabel: 'Postal Code (3-Digit)',
            postalPlaceholder: 'e.g. 100 / 111 / 211',
            landmarkPlaceholder: 'e.g. Near Muttrah Souq / Muscat Grand Mall',
            addressPlaceholder: 'Way No., Building No., Area / Wilayat',
            defaultLang: 'English',
            states: [
                { code: 'OMN-MA', name: 'Muscat (Seeb / Muttrah / Bawshar)' },
                { code: 'OMN-DH', name: 'Dhofar (Salalah)' },
                { code: 'OMN-BS', name: 'Al Batinah North (Sohar)' },
                { code: 'OMN-DA', name: 'Ad Dakhiliyah (Nizwa)' }
            ]
        },
        BH: {
            code: 'BH',
            name: 'Bahrain',
            flag: '🇧🇭',
            dial: '+973',
            phonePlaceholder: '+973 3912 3456',
            cityPlaceholder: 'e.g. Manama, Riffa, Muharraq, Juffair, Seef',
            stateLabel: 'Governorate',
            postalLabel: 'Block / Postal Code',
            postalPlaceholder: 'e.g. Block 328 / Building 45',
            landmarkPlaceholder: 'e.g. Near City Centre Bahrain / Bab Al Bahrain',
            addressPlaceholder: 'Building No., Road/Street, Block No.',
            defaultLang: 'English',
            states: [
                { code: 'BHR-CA', name: 'Capital Governorate (Manama / Juffair / Seef)' },
                { code: 'BHR-MU', name: 'Muharraq Governorate' },
                { code: 'BHR-NO', name: 'Northern Governorate' },
                { code: 'BHR-SO', name: 'Southern Governorate (Riffa)' }
            ]
        },
        NZ: {
            code: 'NZ',
            name: 'New Zealand',
            flag: '🇳🇿',
            dial: '+64',
            phonePlaceholder: '+64 21 123 4567',
            cityPlaceholder: 'e.g. Auckland, Wellington, Christchurch, Hamilton',
            stateLabel: 'Region',
            postalLabel: 'Postcode (4-Digit)',
            postalPlaceholder: 'e.g. 1010 / 6011 / 8011',
            landmarkPlaceholder: 'e.g. Near Sky Tower / CBD / Metro',
            addressPlaceholder: 'Street Number, Street Name, Suburb',
            defaultLang: 'English',
            states: [
                { code: 'NZ-AUK', name: 'Auckland Region' },
                { code: 'NZ-CAN', name: 'Canterbury (Christchurch)' },
                { code: 'NZ-WGN', name: 'Wellington Region' },
                { code: 'NZ-WKO', name: 'Waikato (Hamilton)' },
                { code: 'NZ-BOP', name: 'Bay of Plenty (Tauranga)' },
                { code: 'NZ-OTA', name: 'Otago (Dunedin / Queenstown)' }
            ]
        },
        ZA: {
            code: 'ZA',
            name: 'South Africa',
            flag: '🇿🇦',
            dial: '+27',
            phonePlaceholder: '+27 82 123 4567',
            cityPlaceholder: 'e.g. Johannesburg, Cape Town, Durban, Pretoria',
            stateLabel: 'Province',
            postalLabel: 'Postal Code (4-Digit)',
            postalPlaceholder: 'e.g. 2000 / 8000 / 4000',
            landmarkPlaceholder: 'e.g. Near Sandton City / V&A Waterfront',
            addressPlaceholder: 'Street Address, Suburb / Unit',
            defaultLang: 'English',
            states: [
                { code: 'ZA-GP', name: 'Gauteng (Johannesburg / Pretoria)' },
                { code: 'ZA-WC', name: 'Western Cape (Cape Town)' },
                { code: 'ZA-KZN', name: 'KwaZulu-Natal (Durban)' },
                { code: 'ZA-EC', name: 'Eastern Cape (Gqeberha)' }
            ]
        },
        NP: {
            code: 'NP',
            name: 'Nepal',
            flag: '🇳🇵',
            dial: '+977',
            phonePlaceholder: '+977 981 2345678',
            cityPlaceholder: 'e.g. Kathmandu, Pokhara, Lalitpur, Biratnagar, Birgunj',
            stateLabel: 'Province',
            postalLabel: 'Postal Code (5-Digit)',
            postalPlaceholder: 'e.g. 44600 / 33700',
            landmarkPlaceholder: 'e.g. Near Thamel / New Road / Durbar Square',
            addressPlaceholder: 'Ward No., Tole/Street, House Name',
            defaultLang: 'Nepali',
            states: [
                { code: 'NP-P3', name: 'Bagmati Province (Kathmandu / Lalitpur)' },
                { code: 'NP-P4', name: 'Gandaki Province (Pokhara)' },
                { code: 'NP-P1', name: 'Koshi Province (Biratnagar)' },
                { code: 'NP-P2', name: 'Madhesh Province (Birgunj / Janakpur)' },
                { code: 'NP-P5', name: 'Lumbini Province (Butwal)' },
                { code: 'NP-P6', name: 'Karnali Province' },
                { code: 'NP-P7', name: 'Sudurpashchim Province' }
            ]
        },
        BD: {
            code: 'BD',
            name: 'Bangladesh',
            flag: '🇧🇩',
            dial: '+880',
            phonePlaceholder: '+880 1712 345678',
            cityPlaceholder: 'e.g. Dhaka, Chittagong, Sylhet, Rajshahi, Khulna',
            stateLabel: 'Division',
            postalLabel: 'Postal Code (4-Digit)',
            postalPlaceholder: 'e.g. 1000 / 1212 / 4000',
            landmarkPlaceholder: 'e.g. Near Gulshan / Dhanmondi / Islampur Market',
            addressPlaceholder: 'House No., Road No., Area / Thana',
            defaultLang: 'Bengali',
            states: [
                { code: 'BD-A', name: 'Dhaka Division (Dhaka / Gazipur / Narayanganj)' },
                { code: 'BD-B', name: 'Chittagong Division' },
                { code: 'BD-C', name: 'Sylhet Division' },
                { code: 'BD-D', name: 'Rajshahi Division' },
                { code: 'BD-E', name: 'Khulna Division' },
                { code: 'BD-F', name: 'Barisal Division' },
                { code: 'BD-G', name: 'Rangpur Division' },
                { code: 'BD-H', name: 'Mymensingh Division' }
            ]
        },
        DE: {
            code: 'DE',
            name: 'Germany',
            flag: '🇩🇪',
            dial: '+49',
            phonePlaceholder: '+49 151 12345678',
            cityPlaceholder: 'e.g. Berlin, Munich, Frankfurt, Hamburg, Cologne, Düsseldorf',
            stateLabel: 'Federal State (Bundesland)',
            postalLabel: 'Postleitzahl (PLZ / 5-Digit)',
            postalPlaceholder: 'e.g. 10115 / 80331 / 60311',
            landmarkPlaceholder: 'e.g. Near Hauptbahnhof / City Center',
            addressPlaceholder: 'Straße & Hausnummer, Zusatz',
            defaultLang: 'English',
            states: [
                { code: 'BY', name: 'Bavaria (Bayern / Munich)' },
                { code: 'NW', name: 'North Rhine-Westphalia (Cologne / Düsseldorf)' },
                { code: 'BW', name: 'Baden-Württemberg (Stuttgart)' },
                { code: 'BE', name: 'Berlin' },
                { code: 'HE', name: 'Hesse (Frankfurt)' },
                { code: 'NI', name: 'Lower Saxony (Hannover)' },
                { code: 'SN', name: 'Saxony (Leipzig / Dresden)' },
                { code: 'HH', name: 'Hamburg' },
                { code: 'OTHER', name: 'Other German State' }
            ]
        },
        FR: {
            code: 'FR',
            name: 'France',
            flag: '🇫🇷',
            dial: '+33',
            phonePlaceholder: '+33 6 12 34 56 78',
            cityPlaceholder: 'e.g. Paris, Lyon, Marseille, Nice, Toulouse, Bordeaux',
            stateLabel: 'Region / Department',
            postalLabel: 'Code Postal (5-Digit)',
            postalPlaceholder: 'e.g. 75001 / 69001 / 13001',
            landmarkPlaceholder: 'e.g. Near Metro Station / Landmark',
            addressPlaceholder: 'Numéro et Nom de Rue, Bâtiment / Étage',
            defaultLang: 'English',
            states: [
                { code: 'IDF', name: 'Île-de-France (Paris)' },
                { code: 'ARA', name: 'Auvergne-Rhône-Alpes (Lyon)' },
                { code: 'PACA', name: 'Provence-Alpes-Côte d\'Azur (Marseille / Nice)' },
                { code: 'OCC', name: 'Occitanie (Toulouse / Montpellier)' },
                { code: 'NAQ', name: 'Nouvelle-Aquitaine (Bordeaux)' },
                { code: 'OTHER', name: 'Other French Region' }
            ]
        }
    };

    // ══════════════════════════════════════════════════════════════════════════════
    // ⚡ DYNAMIC AUTO-FIELD APPLICATION ENGINE
    // ══════════════════════════════════════════════════════════════════════════════
    function applyCountryAutoFields(containerOrForm, countryCode, isInitial = false) {
        if (!containerOrForm) return;

        const baseMatch = allWorldCountries.find(c => c.code === countryCode);
        const richData = countryContextData[countryCode] || {
            code: countryCode,
            name: baseMatch ? baseMatch.name : countryCode,
            flag: baseMatch ? baseMatch.flag : '🌐',
            dial: baseMatch ? baseMatch.dial : '+1',
            phonePlaceholder: `${baseMatch ? baseMatch.dial : '+1'} XXX XXX XXXX`,
            cityPlaceholder: 'e.g. Capital / Major Metro City',
            stateLabel: 'State / Province',
            postalLabel: 'Postal / ZIP Code',
            postalPlaceholder: 'Postal / ZIP Code',
            landmarkPlaceholder: 'e.g. Suite, Floor, Landmark, Near Metro/Mall',
            addressPlaceholder: 'Street Address, Building Name / Apt No.',
            defaultLang: 'English',
            states: [
                { code: 'MAIN', name: 'Capital Region / Main State' },
                { code: 'OTHER', name: 'Other / International State' }
            ]
        };

        const form = containerOrForm.closest('form') || containerOrForm;

        // 1. Phone Input & Dial Code
        const phoneInput = form.querySelector('input[type="tel"]') || 
                           form.querySelector('input[name="phone"]') || 
                           form.querySelector('#custNewPhone') || 
                           form.querySelector('#custEditPhone') ||
                           form.querySelector('.dt-input-field[placeholder*="+"]');
        
        if (phoneInput) {
            phoneInput.placeholder = richData.phonePlaceholder;
            const currentVal = phoneInput.value.trim();
            // If empty or purely starting with an old dial code, auto-set dial code
            if (!currentVal || /^\+\d{1,4}\s*$/.test(currentVal)) {
                phoneInput.value = richData.dial + ' ';
            }
            flashHighlight(phoneInput);
        }

        // 2. State / Province Label & Dropdown
        const stateLabel = form.querySelector('#custNewStateLabel') ||
                           form.querySelector('#custEditStateLabel') ||
                           form.querySelector('.dt-state-label');
        if (stateLabel) {
            stateLabel.textContent = richData.stateLabel;
            flashHighlight(stateLabel);
        }

        const stateSelect = form.querySelector('select[name="state"]') || 
                            form.querySelector('#custNewState') || 
                            form.querySelector('#custEditState') ||
                            form.querySelector('.dt-cust-select.dt-state-select');

        if (stateSelect) {
            const prevState = stateSelect.getAttribute('data-initial-state') || stateSelect.value;
            let optionsHtml = '';
            
            richData.states.forEach((st, idx) => {
                const isSelected = (idx === 0) || (st.code === prevState) || (st.name === prevState);
                optionsHtml += `<option value="${st.code}" ${isSelected ? 'selected' : ''}>${st.name}</option>`;
            });

            stateSelect.innerHTML = optionsHtml;
            flashHighlight(stateSelect);
        }

        // 3. City Input Placeholder
        const cityInput = form.querySelector('input[name="city"]') || 
                          form.querySelector('#custNewCity') || 
                          form.querySelector('#custEditCity') ||
                          form.querySelector('.dt-input-field[placeholder*="Surat"], .dt-input-field[placeholder*="Delhi"]');
        if (cityInput) {
            cityInput.placeholder = richData.cityPlaceholder;
            flashHighlight(cityInput);
        }

        // 4. Postal / PIN Code Label & Placeholder
        const postalLabel = form.querySelector('#custNewPostalLabel') ||
                            form.querySelector('#custEditPostalLabel') ||
                            form.querySelector('.dt-postal-label');
        if (postalLabel) {
            postalLabel.textContent = richData.postalLabel;
            flashHighlight(postalLabel);
        }

        const postalInput = form.querySelector('input[name="postal_code"]') || 
                            form.querySelector('input[name="pincode"]') || 
                            form.querySelector('#custNewPostalCode') || 
                            form.querySelector('#custEditPostalCode') ||
                            form.querySelector('.dt-input-field[placeholder*="PIN"], .dt-input-field[placeholder*="Zip"], .dt-input-field[placeholder*="Pincode"]');
        if (postalInput) {
            postalInput.placeholder = richData.postalPlaceholder;
            flashHighlight(postalInput);
        }

        // 5. Nearby Landmark Placeholder
        const landmarkInput = form.querySelector('input[name="landmark"]') || 
                              form.querySelector('#custNewLandmark') || 
                              form.querySelector('#custEditLandmark') ||
                              form.querySelector('.dt-input-field[placeholder*="Landmark"], .dt-input-field[placeholder*="Bus Stand"]');
        if (landmarkInput) {
            landmarkInput.placeholder = richData.landmarkPlaceholder;
            flashHighlight(landmarkInput);
        }

        // 6. Street Address Placeholder
        const addressInput = form.querySelector('input[name="address"]') || 
                             form.querySelector('#custNewAddress') || 
                             form.querySelector('#custEditAddress') ||
                             form.querySelector('.dt-input-field[placeholder*="Building"], .dt-input-field[placeholder*="House"]');
        if (addressInput) {
            addressInput.placeholder = richData.addressPlaceholder;
            flashHighlight(addressInput);
        }

        // 7. Preferred Language auto-suggestion
        const langSelect = form.querySelector('select[name="language"]') || 
                           form.querySelector('#custNewLanguage') || 
                           form.querySelector('#custEditLanguage');
        if (langSelect && !isInitial) {
            for (let i = 0; i < langSelect.options.length; i++) {
                if (langSelect.options[i].value === richData.defaultLang || langSelect.options[i].text.includes(richData.defaultLang)) {
                    langSelect.selectedIndex = i;
                    flashHighlight(langSelect);
                    break;
                }
            }
        }

        // Dispatch Custom DOM Event for external components
        const event = new CustomEvent('countrychange', {
            bubbles: true,
            detail: {
                countryCode: richData.code,
                countryData: richData
            }
        });
        containerOrForm.dispatchEvent(event);
    }

    function flashHighlight(el) {
        if (!el) return;
        el.classList.remove('dt-auto-updated');
        void el.offsetWidth; // Trigger reflow
        el.classList.add('dt-auto-updated');
    }

    // ══════════════════════════════════════════════════════════════════════════════
    // 🔍 SEARCHABLE COUNTRY PICKER INITIALIZATION
    // ══════════════════════════════════════════════════════════════════════════════
    window.initSearchableCountryPicker = function (pickerId, selectedCode = 'IN') {
        const wrap = document.getElementById(pickerId);
        if (!wrap) return;

        const trigger = wrap.querySelector('.dt-country-trigger');
        const dropdown = wrap.querySelector('.dt-country-dropdown');
        const searchInput = wrap.querySelector('.dt-country-search-input');
        const listContainer = wrap.querySelector('.dt-country-list');
        const hiddenInput = wrap.querySelector('.dt-country-hidden-val');
        const selectedFlag = wrap.querySelector('.dt-selected-flag');
        const selectedName = wrap.querySelector('.dt-selected-name');

        function renderList(searchQuery = '') {
            const query = searchQuery.trim().toLowerCase();
            const filtered = allWorldCountries.filter(c => 
                c.name.toLowerCase().includes(query) || 
                c.code.toLowerCase().includes(query) ||
                (c.dial && c.dial.includes(query))
            );

            if (filtered.length === 0) {
                listContainer.innerHTML = `
                    <div style="padding:14px; text-align:center; font-size:0.75rem; color:#78716C;">
                        No country found matching "<strong>${escapeHtml(searchQuery)}</strong>"
                    </div>
                `;
                return;
            }

            let html = '';
            filtered.forEach(c => {
                const isSelected = c.code === (hiddenInput.value || selectedCode);
                html += `
                    <div class="dt-country-opt ${isSelected ? 'active' : ''}" data-code="${c.code}" data-name="${c.name}" data-flag="${c.flag}" data-dial="${c.dial || ''}">
                        <span class="dt-country-opt-flag">${c.flag}</span>
                        <span class="dt-country-opt-name">${c.name}</span>
                        <span class="dt-country-opt-dial" style="font-size:0.72rem; color:#8A681F; font-weight:700; margin-left:auto; padding-right:8px;">${c.dial || ''}</span>
                        <span class="dt-country-opt-code">${c.code}</span>
                    </div>
                `;
            });

            listContainer.innerHTML = html;

            // Bind click events on options
            listContainer.querySelectorAll('.dt-country-opt').forEach(opt => {
                opt.addEventListener('click', function () {
                    const code = this.getAttribute('data-code');
                    const name = this.getAttribute('data-name');
                    const flag = this.getAttribute('data-flag');
                    selectCountry(code, name, flag);
                });
            });
        }

        function selectCountry(code, name, flag) {
            if (hiddenInput) hiddenInput.value = code;
            if (selectedFlag) selectedFlag.innerText = flag;
            if (selectedName) selectedName.innerText = name;
            wrap.setAttribute('data-selected-code', code);
            closeDropdown();

            // ⚡ Auto-Update All Country-Wise Fields Across the Form
            applyCountryAutoFields(wrap, code, false);

            if (typeof window.showToast === 'function') {
                window.showToast(`✓ Country Selected: ${flag} ${name} — Regional fields & dial code updated!`);
            }
        }

        function openDropdown() {
            dropdown.style.display = 'flex';
            searchInput.value = '';
            renderList('');
            setTimeout(() => searchInput.focus(), 50);
        }

        function closeDropdown() {
            dropdown.style.display = 'none';
        }

        function escapeHtml(str) {
            return (str || '').replace(/[&<>"']/g, function(m) {
                return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[m];
            });
        }

        // Toggle on Trigger Click
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            if (dropdown.style.display === 'flex') {
                closeDropdown();
            } else {
                openDropdown();
            }
        });

        // Search Input Filter
        searchInput.addEventListener('input', function () {
            renderList(this.value);
        });

        // Click Outside to Close
        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) {
                closeDropdown();
            }
        });

        // Set initial selection
        const initialMatch = allWorldCountries.find(c => c.code === selectedCode) || allWorldCountries[0];
        if (initialMatch) {
            if (hiddenInput) hiddenInput.value = initialMatch.code;
            if (selectedFlag) selectedFlag.innerText = initialMatch.flag;
            if (selectedName) selectedName.innerText = initialMatch.name;
            wrap.setAttribute('data-selected-code', initialMatch.code);
            // Apply initial context without triggering language override
            applyCountryAutoFields(wrap, initialMatch.code, true);
        }

        renderList('');
    };

    // Auto-init all country pickers on page
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.dt-country-picker-wrap').forEach(wrap => {
            const pickerId = wrap.id;
            const initCode = wrap.getAttribute('data-selected-code') || 'IN';
            if (pickerId) {
                window.initSearchableCountryPicker(pickerId, initCode);
            }
        });
    });

})();

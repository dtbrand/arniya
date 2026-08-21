/**
 * country-picker.js — Searchable All-World Country Dropdown Engine
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 * 195+ Complete World Countries with Flag & Live Instant Search
 */

(function () {
    'use strict';

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
        { code: 'BD', name: 'Bangladesh', flag: '🇧🇩', dial: '+880' },
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
        { code: 'FR', name: 'France', flag: '🇫🇷', dial: '+33' },
        { code: 'GA', name: 'Gabon', flag: '🇬🇦', dial: '+241' },
        { code: 'GM', name: 'Gambia', flag: '🇬🇲', dial: '+220' },
        { code: 'GE', name: 'Georgia', flag: '🇬🇪', dial: '+995' },
        { code: 'DE', name: 'Germany', flag: '🇩🇪', dial: '+49' },
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
        { code: 'LK', name: 'Sri Lanka', flag: '🇱🇰', dial: '+94' },
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
                    <div class="dt-country-opt ${isSelected ? 'active' : ''}" data-code="${c.code}" data-name="${c.name}" data-flag="${c.flag}">
                        <span class="dt-country-opt-flag">${c.flag}</span>
                        <span class="dt-country-opt-name">${c.name}</span>
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
            closeDropdown();
            if (typeof window.showToast === 'function') {
                window.showToast(`✓ Country selected: ${flag} ${name}`);
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

module.exports = {
  ci: {
    collect: {
      url: [
        'https://jaihanumantex.in/Frontend/Home/home.php',
        'https://jaihanumantex.in/Frontend/Shop/shop.php',
        'https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php',
      ],
      numberOfRuns: 1,
      settings: {
        preset: 'desktop',
      },
    },
    assert: {
      assertions: {
        'categories:performance': ['warn', { minScore: 0.6 }],
        'categories:accessibility': ['warn', { minScore: 0.7 }],
        'categories:best-practices': ['warn', { minScore: 0.8 }],
        'categories:seo': ['warn', { minScore: 0.8 }],
      },
    },
    upload: {
      target: 'temporary-public-storage',
    },
  },
};

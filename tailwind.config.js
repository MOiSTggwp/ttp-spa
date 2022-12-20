module.exports = {
  content: [
      './storage/framework/views/*.php',
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
  ],
  theme: {
    extend: {
        aspectRatio: {
            '4/3': '4 / 3',
        },
        colors: {
            'Dark': '#23262F',
            'Dark-l': '#87898E',
            'Dark-m': '#484C56',
            'Light': '#FCFCFD',
            'Light-l': '#DFDFE6',
            'Light-m': '#F1F1F1',
            'Info': '#3772FF',
            'Info-l': '#34ADFE',
            'Info-m': '#0186DF',
            'Error': '#E8726C',
            'Error-l': '#F4BCB9',
            'Error-m': '#EE8877',
            'Done': '#4C906E',
            'Done-l': '#A1CEB7',
            'Done-m': '#87C0A2',
            'Warn': '#F6B05D',
            'Warn-l': '#F9D19F',
            'Warn-m': '#F8C78B',
        },
    },
  },
  plugins: [],
}

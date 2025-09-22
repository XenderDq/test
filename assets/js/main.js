document.addEventListener('DOMContentLoaded', () => {
    const filterContainer = document.querySelector('.filter-container');
    const items = document.querySelectorAll('.content-block-item');
    const categoryMap = new Map();
    items.forEach(item => {
        const categories = item.dataset.categories.split(',').map(c => c.trim());
        categories.forEach(category => {
            if(!categoryMap.has(category)) {
                categoryMap.set(category, []);
            }
            categoryMap.get(category).push(item);
        });
    });
    filterContainer.addEventListener('click', ({ target }) => {
        const tab = target.closest('.filter-tab');
        if(!tab) return;
        const activeTab = filterContainer.querySelector('.filter-tab.active');
        if(activeTab) {
            activeTab.classList.remove('active');
        }
        tab.classList.add('active');
        const filter = tab.dataset.tab;
        const showAll = filter === 'all';
        items.forEach(item => item.style.display = 'none');
        if (showAll) {
            items.forEach(item => item.style.display = '');
        } else {
            categoryMap.get(filter)?.forEach(item => {
                item.style.display = '';
            });
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
  const tabsContainer = document.querySelector('.aplicant-tabs');
  const items = document.querySelectorAll('.aplicant_tab-item');
  tabsContainer.addEventListener('click', (e) => {
    const tab = e.target.closest('.aplicant-tab');
    if (!tab) return;
    tabsContainer
      .querySelectorAll('.aplicant-tab')
      .forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    const category = tab.dataset.tab;
    items.forEach(item => {
      const cats = item.dataset.categories.split(',').map(c => c.trim());
      if (category === 'all' || cats.includes(category)) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });
});
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.top_employees-decanat');
    const itemsCount = document.querySelectorAll('.employees_content_item').length;
    if (itemsCount <= 3) {
    container.classList.add('no-hover');
    } 
    if (itemsCount >= 3) {
        document.querySelector('.employees_slider_img-left').style.setProperty('left', '60px');
        document.querySelector('.employees_slider_img-right').style.setProperty('right', '60px');
    }
    if (itemsCount === 2) {
        document.querySelector('.employees_slider_img-left').style.setProperty('left', '320px');
        document.querySelector('.employees_slider_img-right').style.setProperty('right', '320px');
    } 
    if (itemsCount === 1) {
        document.querySelector('.employees_slider_img-left').style.setProperty('left', '570px');
        document.querySelector('.employees_slider_img-right').style.setProperty('right', '570px');
    }
    class Slider {
        constructor() {
            this.slider = document.querySelector('.top_employees_content');
            this.items = Array.from(document.querySelectorAll('.employees_content_item'));
            this.visibleItems = 3;
            this.currentIndex = 0;
            this.isAnimating = false;
            this.itemWidth = 0;
            this.totalItems = this.items.length;

            this.init();
            this.addEventListeners();
        }
        init() {
            if (this.totalItems <= 2) {
                this.slider.style.display = 'flex';
                this.slider.style.justifyContent = 'space-between';
                return;
            }
            const clonesStart = this.items.slice(-this.visibleItems).map(item => item.cloneNode(true));
            const clonesEnd = this.items.slice(0, this.visibleItems).map(item => item.cloneNode(true));
            
            this.slider.prepend(...clonesStart);
            this.slider.append(...clonesEnd);
            
            this.allItems = [...clonesStart, ...this.items, ...clonesEnd];
            this.itemWidth = this.calculateItemWidth();
            
            this.slider.style.transform = `translateX(-${this.itemWidth * this.visibleItems}px)`;
        }
        calculateItemWidth() {
            return this.items[0].offsetWidth + 
                   parseInt(getComputedStyle(this.slider).gap || 0);
        }
        slide(direction) {
            let a = document.querySelector('employees_slider_img-right');
                console.log(a)
            if (this.totalItems <= 2) { 
                
                return;
            }
            if (this.isAnimating) return;
            this.isAnimating = true;

            this.currentIndex += direction;
            const offset = this.itemWidth * (this.visibleItems + this.currentIndex);

            this.slider.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            this.slider.style.transform = `translateX(-${offset}px)`;

            setTimeout(() => {
                if (direction === -1 && this.currentIndex <= -this.visibleItems) {
                    this.currentIndex = this.totalItems - this.visibleItems;
                    this.slider.style.transition = 'none';
                    this.slider.style.transform = `translateX(-${this.itemWidth * (this.visibleItems + this.currentIndex)}px)`;
                }
                else if (direction === 1 && this.currentIndex >= this.totalItems) {
                    this.currentIndex = 0;
                    this.slider.style.transition = 'none';
                    this.slider.style.transform = `translateX(-${this.itemWidth * this.visibleItems}px)`;
                }

                this.isAnimating = false;
            }, 500);
        }
        addEventListeners() {
            const leftArrow = document.querySelector('.employees_slider_img-left');
            const rightArrow = document.querySelector('.employees_slider_img-right');

            leftArrow.addEventListener('click', () => this.slide(-1));
            rightArrow.addEventListener('click', () => this.slide(1));
            
            window.addEventListener('resize', () => {
                if (this.totalItems <= 2) return;
                this.itemWidth = this.calculateItemWidth();
                this.slider.style.transform = `translateX(-${this.itemWidth * (this.visibleItems + this.currentIndex)}px)`;
            });
        }
    }
    new Slider();
});
document.addEventListener('DOMContentLoaded', () => {
  const nameInput = document.getElementById('name');
  const telInput = document.getElementById('tel');
  const emailInput = document.getElementById('email');
  const tellusInput = document.getElementById('tellus');
  const btn = document.querySelector('.feedback-button');
  const toast = document.getElementById('feedback_toast');
  const requiredFields = [
    nameInput,
    telInput,
    emailInput,
    tellusInput
  ];
  requiredFields.forEach(field => {
    if (field) {
      field.dataset.originalPlaceholder = field.placeholder;
    }
  });
  function maskTel() {
    if (!telInput) return;
    const start = this.selectionStart;
    const diff = this.value.length - start;
    let nums = this.value.replace(/\D/g, '');
    if (nums.startsWith('7')) nums = nums.slice(1);
    let v = '+7';
    if (nums.length) {
      v += ' (' + nums.slice(0, 3);
      if (nums.length > 3) v += ') ' + nums.slice(3, 6);
      if (nums.length > 6) v += '-' + nums.slice(6, 8);
      if (nums.length > 8) v += '-' + nums.slice(8, 10);
    }
    this.value = v;
    const pos = v.length - diff;
    this.setSelectionRange(pos, pos);
  }
  function restrictTel(e) {
    if (e.key.length === 1 && !/\d/.test(e.key) && !e.ctrlKey) {
      e.preventDefault();
    }
  }
  if (telInput) {
    telInput.addEventListener('input', maskTel);
    telInput.addEventListener('keydown', restrictTel);
  }
  if (nameInput) {
    nameInput.addEventListener('input', function() {
      this.value = this.value.replace(/[^А-Яа-яЁё\s-]/g, '');
    });
    nameInput.addEventListener('keydown', function(e) {
      if (e.key.length > 1) return; 
      if (!/[А-Яа-яЁё\s-]/.test(e.key)) e.preventDefault();
    });
  }
  requiredFields.forEach(field => {
    if (!field) return;
    field.addEventListener('focus', function() {
      this.style.border = '';
      this.placeholder = this.dataset.originalPlaceholder;
      this.classList.remove('invalid');
      if (this.id === 'tel' && !this.value) {
        this.placeholder = '+7 (___) ___-__-__';
      }
    });
  });
  if (btn) {
    btn.addEventListener('click', () => {
      requiredFields.forEach(field => {
        if (field) {
          field.style.border = '';
          field.placeholder = field.dataset.originalPlaceholder;
        }
      });
      let allValid = true;
      let firstInvalid = null;
      requiredFields.forEach(field => {
        if (!field || !field.value.trim()) {
          allValid = false;
          if (field) {
            field.style.border = '2px solid #ff0000';
            field.placeholder = 'Пожалуйста, заполните это поле';
            firstInvalid = firstInvalid || field;
          }
        }
      });
      if (emailInput && emailInput.value.trim() && !validateEmail(emailInput.value)) {
        allValid = false;
        emailInput.style.border = '2px solid #ff0000';
        emailInput.placeholder = 'Введите корректный email';
        firstInvalid = firstInvalid || emailInput;
      }
      if (!allValid) {
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        showToast('Пожалуйста, заполните все поля корректно', false);
        return;
      }
      const formData = new FormData();
      formData.append('name', nameInput ? nameInput.value.trim() : '');
      formData.append('tel', telInput ? telInput.value.trim() : '');
      formData.append('email', emailInput ? emailInput.value.trim() : '');
      formData.append('tellus', tellusInput ? tellusInput.value.trim() : '');
      fetch('/logic/feedback.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showToast(data.message, true);
            requiredFields.forEach(field => {
              if (field) field.value = '';
            });
          } else {
            showToast(data.message || 'Ошибка при отправке', false);
          }
        })
        .catch(error => {
          console.error('Fetch error:', error);
          showToast('Ошибка сети, попробуйте ещё раз', false);
        });
    });
  }
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
  function showToast(msg, isSuccess) {
    if (!toast) return;
    toast.textContent = msg;
    toast.className = '';
    toast.classList.add(isSuccess ? 'success' : 'error');
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.classList.add('hidden'), 400);
    }, 4000);
  }
});
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('select').forEach(el => el.value = '');
  document.querySelectorAll('input[type="text"]').forEach(el => el.value = '');
  const toast = document.getElementById('toast');
  const submitBtn = document.querySelector('.upload_item-but-but');
  const materialsBlock = document.querySelector('.main_download_materials');
  const dropArea = document.getElementById('drop_area');
  const fileInput = document.getElementById('file_input');
  const fileSelect = document.getElementById('file_select');
  const fileNameDisplay = document.getElementById('file_name');
  let selectedFile = null;
  const allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'ppt', 'pptx'];
  const maxFileSize = 10 * 1024 * 1024;
  function showToast(message, success) {
    toast.textContent = message;
    toast.classList.remove('hidden');
    toast.classList.add('visible');
    toast.style.background = success ? 'rgba(0,128,0,0.85)' : 'rgba(200,0,0,0.85)';
    const hide = () => {
      toast.classList.remove('visible');
      setTimeout(() => toast.classList.add('hidden'), 300);
      document.removeEventListener('click', hide);
    };
    setTimeout(() => document.addEventListener('click', hide, { once: true }), 0);
  }
  function validateFile(file) {
    if (!file || file.type === '') {
      showToast('❌ Файл не выбран или выбран недопустимый объект.', false);
      return false;
    }
    const ext = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(ext)) {
      showToast('❌ Недопустимый тип файла. Разрешены: PDF, DOC(X), TXT, XLS(X), PPT(X)', false);
      return false;
    }
    if (file.size > maxFileSize) {
      showToast('❌ Файл слишком большой. Максимальный размер — 10 МБ.', false);
      return false;
    }
    return true;
  }
  function validateAndShow() {
    const fields = Array.from(document.querySelectorAll(
      '.content_upload select[required], .content_upload input[type="text"][required]'
    ));
    const missing = [];
    fields.forEach(el => {
      const filled = el.tagName === 'SELECT' ? el.selectedIndex > 0 : el.value.trim() !== '';
      if (!filled) {
        const errorText =
          el.getAttribute('error') ||
          el.closest('div')?.querySelector('.upload_lebel, [typ="upload_lebel"]')?.textContent.trim() ||
          el.placeholder || el.name;
        missing.push(errorText);
        el.style.border = '2px solid #ff0000';
      } else {
        el.style.border = '';
      }
    });
    if (!selectedFile) {
      missing.push('Файл материала');
    }
    const unique = [...new Set(missing)];
    if (unique.length) {
      showToast('⚠ Пожалуйста, заполните следующие поля:\n• ' + unique.join('\n• '), false);
      return false;
    }
    if (materialsBlock) {
      materialsBlock.removeAttribute('hidden');
    }
    return true;
  }
  fileSelect.addEventListener("click", () => fileInput.click());
  fileInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file && validateFile(file)) {
      selectedFile = file;
      fileNameDisplay.textContent = file.name;
    } else {
      selectedFile = null;
      this.value = '';
      fileNameDisplay.textContent = 'Файл не выбран';
    }
  });
  dropArea.addEventListener("dragover", function (e) {
    e.preventDefault();
    dropArea.classList.add("dragover");
  });
  dropArea.addEventListener("dragleave", function () {
    dropArea.classList.remove("dragover");
  });
  dropArea.addEventListener("drop", function (e) {
    e.preventDefault();
    dropArea.classList.remove("dragover");
    const file = e.dataTransfer.files[0];
    if (file && validateFile(file)) {
      selectedFile = file;
      fileInput.files = e.dataTransfer.files;
      fileNameDisplay.textContent = file.name;
    } else {
      selectedFile = null;
      fileInput.value = '';
      fileNameDisplay.textContent = 'Файл не выбран';
    }
  });
  if (submitBtn) {
    submitBtn.addEventListener('click', e => {
      e.preventDefault();
      if (!validateAndShow() || !validateFile(selectedFile)) return;
      const formData = new FormData();
      formData.append("file", selectedFile);
      document.querySelectorAll('.content_upload select').forEach(select => {
        if (select.name) {
          formData.append(select.name, select.value);
        }
      });
      document.querySelectorAll('.content_upload input[type="text"]').forEach(input => {
        if (input.name) {
          formData.append(input.name, input.value);
        }
      });
      fetch('/logic/ajax_upload_handler.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
        .then(r => r.json())
        .then(json => {
          if (json.success) {
            showToast(json.message, true);
            document.querySelectorAll('.content_upload input, .content_upload select').forEach(f => f.value = '');
            fileNameDisplay.textContent = 'Файл не выбран';
            selectedFile = null;
          } else {
            if (json.errors) {
              Object.keys(json.errors).forEach(field => {
                const el = document.getElementById(field);
                if (el) el.style.border = '2px solid #ff0000';
              });
              const firstField = Object.keys(json.errors)[0];
              document.getElementById(firstField)?.focus();
              showToast(json.message, false);
            } else {
              showToast(json.message || 'Произошла неизвестная ошибка', false);
            }
          }
        })
        .catch(() => {
          showToast('Ошибка сети, попробуйте ещё раз', false);
        });
    });
  }
});
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.aplicant_tab-text-price').forEach(el => {
    const yearly = parseFloat(el.getAttribute('value'));
    if (isNaN(yearly)) return; 
    const monthly = Math.round(yearly / 12);
    el.textContent = `${yearly} рублей в год или ${monthly} в месяц`;
  });
});
document.addEventListener('DOMContentLoaded', function() {
  const calculateButton = document.querySelector('.calculation-button');
  const inputs = document.querySelectorAll('.top_calculation_form_input input');
  const resultTextarea = document.getElementById('answ');
  const resultContainer = document.querySelector('.calculation_tellus-text');
  const checkboxes = document.querySelectorAll('.exclusive-checkbox');
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      if (this.checked) {
        checkboxes.forEach(otherCheckbox => {
          if (otherCheckbox !== this) {
            otherCheckbox.checked = false;
          }
        });
      }
    });
  });
  calculateButton.addEventListener('click', function(e) {
  e.preventDefault();
  let allFilled = true;
  const values = [];
  inputs.forEach(input => {
    if (!input.value.trim()) {
      allFilled = false;
      input.style.border = '2px solid #ff0000';
      input.placeholder = 'Пожалуйста, заполните это поле';
    } else {
      input.style.border = '';
      values.push(parseFloat(input.value));
    }
  });
  if (!allFilled) {
    showToast('⚠ Пожалуйста, заполните все поля', false);
    return;
  }
  if (values.some(isNaN)) {
    showToast('⚠ Пожалуйста, введите корректные числа', false);
    inputs.forEach(input => {
      if (!input.value.trim() || isNaN(parseFloat(input.value))) {
        input.style.border = '2px solid #ff0000';
      }
    });
    return;
  }
  let isOge = false;
  let applicantAvg = 0;
  let budgetChance = 0;
  let resultText = "";
  let generalChance = 0;
  let avgAll, freePlaces, totalPlaces;
  if (document.getElementById('check1').checked) {
    avgAll = 183;
    freePlaces = 20;
    totalPlaces = 80;
    applicantAvg = values.reduce((sum, val) => sum + val, 0);
     budgetChance = calculateBudgetChance(applicantAvg, avgAll, freePlaces, totalPlaces);
    generalChance = calculateGeneralChance(applicantAvg, avgAll);
    resultText = `Шанс поступления на бюджет: ${budgetChance}%\n` +
                `Шанс общего поступления: ${generalChance}%\n` +
                `Общая сумма ваших баллов: ${applicantAvg.toFixed(1)}\n` +
                `Средняя сумма баллов прошлых лет: ${avgAll}`;
  } 
  else if (document.getElementById('check2').checked) {
    avgAll = 4; 
    freePlaces = 30;
    totalPlaces = 40;
    applicantAvg = values.reduce((sum, val) => sum + val, 0) / values.length;
    budgetChance = calculateBudgetChance(applicantAvg, avgAll, freePlaces, totalPlaces, isOge);
    generalChance = calculateGeneralChance(applicantAvg, avgAll, isOge);
    resultText = `Шанс поступления на бюджет: ${budgetChance}%\n` +
                `Шанс общего поступления: ${generalChance}%\n` +
                `Ваш средний балл: ${applicantAvg.toFixed(1)}\n` +
                `Средний балл прошлых лет: ${avgAll}`;
  }
  if (!document.getElementById('check1').checked && !document.getElementById('check2').checked) {
    showToast('⚠ Пожалуйста, выберите тип экзамена', false);
    return;
  }
  if (isNaN(avgAll) || isNaN(freePlaces) || isNaN(totalPlaces)) {
    showToast('⚠ Ошибка в данных для расчета', false);
    return;
  }
  resultTextarea.value = resultText;
  resultContainer.removeAttribute('hidden');
  resultTextarea.setAttribute('readonly', 'readonly');
  inputs.forEach(input => {
    input.style.border = '';
  });
});
function calculateBudgetChance(applicantAvg, avgAll, freePlaces, totalPlaces, isOge = false) {
  const diff = applicantAvg - avgAll;
  let chance;
  if (isOge) {
    chance = 50 + (diff * 25); 
  } else {
    chance = 50 + (diff * 1);
  }
  const placeRatio = (freePlaces / totalPlaces) * 100;
  const finalChance = (chance * 0.7) + (placeRatio * 0.3);
  return Math.max(1, Math.min(100, Math.round(finalChance)));
}
function calculateGeneralChance(applicantAvg, avgAll, isOge = false) {
  let chance;
  if (isOge) {
    chance = 70 + (applicantAvg - avgAll) * 30;
  } else {
    chance = 70 + (applicantAvg - avgAll);
  }
  return Math.max(10, Math.min(99, Math.round(chance)));
}
  const toast = document.getElementById('toast');
  function showToast(message, success) {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.remove('hidden');
    toast.classList.add('visible');
    toast.style.background = success
      ? 'rgba(0,128,0,0.85)'
      : 'rgba(200,0,0,0.85)';
    const hide = () => {
      toast.classList.remove('visible');
      setTimeout(() => toast.classList.add('hidden'), 300);
      document.removeEventListener('click', hide);
    };
    setTimeout(() => {
      document.addEventListener('click', hide, { once: true });
    }, 0);
  }
  inputs.forEach(input => {
    input.addEventListener('input', function() {
      this.style.border = '';
      this.placeholder = this.dataset.originalPlaceholder || this.placeholder;
    });
    input.dataset.originalPlaceholder = input.placeholder;
  });
});
 document.addEventListener('DOMContentLoaded', function() {
            const forgotPassword = document.querySelector('.call_back_text');
            const alertBox = document.querySelector('.hiddent_alert_login');
            const backdrop = document.querySelector('.alert-backdrop');
            const closeBtn = document.querySelector('.alert-close');
            forgotPassword.addEventListener('click', function(e) {
                e.stopPropagation();
                backdrop.removeAttribute('hidden');
                backdrop.classList.add('visible');
                alertBox.removeAttribute('hidden');
                setTimeout(() => {
                    alertBox.classList.add('visible');
                }, 10);
            });
            closeBtn.addEventListener('click', function() {
                hideAlert();
            });
            backdrop.addEventListener('click', function() {
                hideAlert();
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideAlert();
                }
            });
            function hideAlert() {
                if (!alertBox.hasAttribute('hidden')) {
                    alertBox.classList.remove('visible');
                    backdrop.classList.remove('visible');
                    setTimeout(() => {
                        alertBox.setAttribute('hidden', '');
                        backdrop.setAttribute('hidden', '');
                    }, 500);
                }
            }
        });
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.aplicant_and_admission-tab');
  const contents = document.querySelectorAll('[data-categories-apl]');
  contents.forEach(el => el.hidden = true);
  if (tabs.length) {
    tabs[0].classList.add('active');
    const firstCat = tabs[0].dataset.tab;
    document
      .querySelectorAll(`[data-categories-apl~=\"${firstCat}\"]`)
      .forEach(el => el.hidden = false);
  }
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const category = tab.dataset.tab;
      contents.forEach(content => {
        const cats = content.dataset.categoriesApl
                          .split(',')
                          .map(c => c.trim());
        content.hidden = !cats.includes(category);
      });
    });
  });
});
document.addEventListener('DOMContentLoaded', function () {
  const calculateButton = document.querySelector('.search_item-but-but');
  const inputs = document.querySelectorAll('.search_item-input input');
  const hidremoveTit = document.querySelector('.excel_group_download-title');
  const hidremoveImg = document.querySelector('.excel_group_download-image');
  const hidremoveImgEx = document.querySelector('.excel_img');
  const toast_excell = document.getElementById('toast_excell');
  calculateButton.addEventListener('click', function (e) {
    e.preventDefault();
    let allFilled = true;
    inputs.forEach(input => {
      if (!input.value.trim()) {
        allFilled = false;
        input.style.border = '2px solid #ff0000';
        input.placeholder = 'Пожалуйста, заполните это поле';
      }
    });
    if (allFilled) {
      const formData = new FormData();
      inputs.forEach(input => {
        formData.append(input.name, input.value.trim());
      });
      fetch('/logic/ajax_get_excell.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Сетевая ошибка');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          const downloadLink = document.querySelector('.excell_a-download');
          downloadLink.href = data.filePath; 
          hidremoveTit.textContent = "Скачать учебный план для группы" + " " + data.groupName;
          hidremoveTit.hidden = false;  
          hidremoveImg.hidden = false;
          hidremoveImgEx.hidden = false;

          showToast('Файл успешно загружен!', true);
        } else {
          showToast(data.message || 'Произошла ошибка', false);
        }
      })
      .catch(err => {
        showToast('Ошибка сети, попробуйте ещё раз', false);
      });
    }
  });
  function showToast(msg, isSuccess) {
    toast_excell.textContent = msg;
    toast_excell.className = ''; 
    toast_excell.classList.add(isSuccess ? 'success' : 'error');
    toast_excell.classList.remove('hidden');
    setTimeout(() => toast_excell.classList.add('show'), 10);
    setTimeout(() => {
      toast_excell.classList.remove('show');
      setTimeout(() => toast_excell.classList.add('hidden'), 400);
    }, 4000);
  }
});
document.addEventListener('DOMContentLoaded', function () { 
  const loginLink = document.querySelector('.header_login-link');
  const paddingRemove = document.querySelector('.header_auth-item');
  const loginText = loginLink.textContent;
  if (loginText !== 'Войти') {
    paddingRemove.style.padding = '0 4px';
  }
});
document.addEventListener('DOMContentLoaded', function() {
    const educationSelect = document.getElementById('education');
    const directionSelect = document.getElementById('direction');
    const courseSelect = document.getElementById('course');
    if (!educationSelect || !directionSelect || !courseSelect) {
        console.error('Один или несколько элементов не найдены на странице');
        return;
    }
    educationSelect.addEventListener('change', function() {
        directionSelect.innerHTML = '<option value="" disabled selected hidden>Выберите направление...</option>';
        courseSelect.innerHTML = '<option value="" disabled selected hidden>Выберите курс...</option>';
        directionSelect.disabled = true;
        courseSelect.disabled = true;
        const selectedLevel = this.value;
        let levelCode = null;
        for (const code in educationData) {
            if (educationData[code].name === selectedLevel) {
                levelCode = code;
                break;
            }
        }
        if (!levelCode) return;
        const directions = educationData[levelCode].directions;
        for (const directionName in directions) {
            const option = document.createElement('option');
            option.value = directionName;
            option.textContent = directionName;
            directionSelect.appendChild(option);
        }
        directionSelect.disabled = false;
    });
    directionSelect.addEventListener('change', function() {
        courseSelect.innerHTML = '<option value="" disabled selected hidden>Выберите курс...</option>';
        courseSelect.disabled = true;
        const selectedLevel = educationSelect.value;
        const selectedDirection = this.value;
        let levelCode = null;
        for (const code in educationData) {
            if (educationData[code].name === selectedLevel) {
                levelCode = code;
                break;
            }
        }
        if (!levelCode) return;
        const coursesCount = educationData[levelCode].directions[selectedDirection];
        for (let i = 1; i <= coursesCount; i++) {
            const option = document.createElement('option');
            option.value = `${i} курс`;
            option.textContent = `${i} курс`;
            courseSelect.appendChild(option);
        }
        courseSelect.disabled = false;
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggle = document.getElementById('loginDropdown');
    const dropdownMenu = dropdownToggle.nextElementSibling;
    dropdownToggle.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenu.classList.toggle('show');
    });
    document.addEventListener('click', function(event) {
        if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
    const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            dropdownMenu.classList.remove('show');
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
     const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]'); 
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!form.username.value.trim() || !form.password.value) {
            showToast('Заполните все поля');
            return;
        }
        const originalText = submitBtn.textContent;
        try {
            const formData = new FormData(this);
            const response = await fetch('/logic/login.php', {
                method: 'POST',
                body: formData
            }); 
            const result = await response.json();
            
            if (result.success) {
                window.location.href = result.redirect;
            } else {
                showToast(result.error || 'Unknown error');
            }
        } catch (error) {
            showToast('Network error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText; 
        }
    });
        function showToast(msg, isSuccess = false) { 
        const toast = document.getElementById('toast');
        toast.classList.remove('success', 'error', 'visible', 'hidden');
        toast.classList.add(isSuccess ? 'success' : 'error');
        toast.classList.remove('hidden');
        toast.textContent = msg;
        setTimeout(() => {
            toast.classList.add('visible');
        }, 10); 
        setTimeout(() => {
            toast.classList.remove('visible');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300);
        }, 4000);
    }
});
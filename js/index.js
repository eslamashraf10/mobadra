const menuItems = document.querySelectorAll('.menu li');

menuItems.forEach((li) =>
  li.addEventListener('click', (e) => {
    e.preventDefault();

    menuItems.forEach((item) => item.classList.remove('active'));

    const targetLi = e.currentTarget;
    targetLi.classList.add('active');

    const target = targetLi.getAttribute('data-target');

    document.querySelectorAll('#mainContent .page').forEach((page) => {
      const pageId = page.getAttribute('id');
      if (pageId === target) {
        page.classList.remove('d-none');
      } else {
        page.classList.add('d-none');
      }
    });
  })
);


document.querySelector('aside .asideToggle').addEventListener('click',(e)=>{
   const aside = document.querySelector('aside');
   aside.classList.toggle('translateX-aside');
   e.target.classList.toggle('rotateToggle');
})

const toastElement = document.getElementById('solutionToast');
let solutionToastInstance = null;
if (toastElement) {
  solutionToastInstance = bootstrap.Toast.getOrCreateInstance(toastElement, {
    delay: 2500
  });
}

const toastBody = toastElement?.querySelector('.toast-body');

const showSolutionToast = (message, variant = 'success') => {
  if (!toastElement || !solutionToastInstance || !toastBody) return;

  toastElement.classList.remove('bg-success', 'bg-danger', 'bg-warning');
  let colorClass = 'bg-success';
  if (variant === 'error') {
    colorClass = 'bg-danger';
  } else if (variant === 'warning') {
    colorClass = 'bg-warning';
  }
  toastElement.classList.add(colorClass);
  toastBody.textContent = message;
  solutionToastInstance.show();
};

const solveButtons = document.querySelectorAll('.solveBtn');
const textAreas = document.querySelectorAll('.solutionForm textarea');

textAreas.forEach((textarea) => {
  textarea.addEventListener('input', () => {
    textarea.classList.remove('is-invalid');
  });
});

solveButtons.forEach((button) => {
  button.addEventListener('click', () => {
    let targetTextarea = button.closest('.modal-content')
      ? button.closest('.modal-content').querySelector('.solutionForm textarea')
      : button.closest('.card-body')?.querySelector('.solutionForm textarea');

    if (!targetTextarea) {
      targetTextarea = document.querySelector('#issueDetailsModal .solutionForm textarea');
    }

    if (!targetTextarea) return;

    if (!targetTextarea.value.trim()) {
      targetTextarea.classList.add('is-invalid');
      showSolutionToast('Please enter the solution before saving.', 'error');
      return;
    }

    targetTextarea.classList.remove('is-invalid');
    showSolutionToast('Solution saved successfully.');
    targetTextarea.value = '';
  });
});

const replyCards = document.querySelectorAll('.replyCard');

const updateReplyCardState = (card, isRead) => {
  card.classList.toggle('reply-read', isRead);
  const statusBadge = card.querySelector('.replyStatus');

  if (statusBadge) {
    statusBadge.classList.remove('info', 'success');
    statusBadge.classList.add(isRead ? 'success' : 'info');
    statusBadge.textContent = isRead ? 'Read' : 'New Reply';
  }
};

const replyInlineToggles = document.querySelectorAll('.replyInlineToggle');

replyInlineToggles.forEach((button) => {
  button.addEventListener('click', () => {
    const card = button.closest('.replyCard');
    const form = card?.querySelector('.replyInlineForm');
    if (!form) return;

    const textarea = form.querySelector('textarea');
    const isHidden = form.classList.contains('d-none');

    document.querySelectorAll('.replyInlineForm').forEach((f) => {
      if (f !== form) {
        f.classList.add('d-none');
        const area = f.querySelector('textarea');
        if (area) area.classList.remove('is-invalid');
      }
    });

    if (isHidden) {
      form.classList.remove('d-none');
      textarea?.focus();
    } else {
      form.classList.add('d-none');
    }
  });
});

document.querySelectorAll('.replyInlineForm').forEach((form) => {
  const textarea = form.querySelector('textarea');
  const cancelBtn = form.querySelector('.cancelReplyInlineBtn');

  cancelBtn?.addEventListener('click', () => {
    if (textarea) {
      textarea.value = '';
      textarea.classList.remove('is-invalid');
    }
    form.classList.add('d-none');
  });

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (!textarea) return;

    const value = textarea.value.trim();
    if (!value) {
      textarea.classList.add('is-invalid');
      showSolutionToast('Please enter a reply before submitting.', 'error');
      return;
    }

    textarea.classList.remove('is-invalid');

    const card = form.closest('.replyCard');
    if (!card) return;

    updateReplyCardState(card, true);

    const preview = card.querySelector('.userReplyPreview');
    const previewText = card.querySelector('.userReplyPreviewText');
    if (preview && previewText) {
      previewText.textContent = value;
      preview.classList.remove('d-none');
    }

    textarea.value = '';
    form.classList.add('d-none');
    showSolutionToast('Reply submitted successfully.');
  });
});

const respondModalElement = document.getElementById('respondToIssueModal');
const closeIssueBtn = respondModalElement?.querySelector('.closeIssueBtn');
const acceptedResponsesByIssue = {};
let activeIssueId = null;

const resetResponseStates = () => {
  respondModalElement
    ?.querySelectorAll('.modelRespondBody')
    .forEach((body) => {
      body.classList.remove('acceptedResponse');
      const tag = body.querySelector('.responseTag');
      if (tag) {
        tag.classList.remove('bg-success');
        tag.classList.add('bg-secondary');
        tag.textContent = 'Solution';
      }
      const acceptBtn = body.querySelector('.acceptSolutionBtn');
      if (acceptBtn) {
        acceptBtn.disabled = false;
        acceptBtn.innerHTML = '<i class="fa-solid fa-check"></i> Accept Solution';
        acceptBtn.classList.remove('btn-success');
        acceptBtn.classList.add('btn-outline-success');
      }
    });
};

respondModalElement?.addEventListener('show.bs.modal', (event) => {
  const trigger = event.relatedTarget;
  activeIssueId = trigger?.getAttribute('data-issue-id') || null;
  resetResponseStates();

  const acceptedResponseId = acceptedResponsesByIssue[activeIssueId];
  if (acceptedResponseId) {
    const acceptedBody = respondModalElement.querySelector(
      `.modelRespondBody[data-response-id="${acceptedResponseId}"]`
    );
    if (acceptedBody) {
      const tag = acceptedBody.querySelector('.responseTag');
      tag?.classList.remove('bg-secondary');
      tag?.classList.add('bg-success');
      if (tag) tag.textContent = 'Accepted';

      const acceptBtn = acceptedBody.querySelector('.acceptSolutionBtn');
      if (acceptBtn) {
        acceptBtn.disabled = true;
        acceptBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Accepted';
        acceptBtn.classList.remove('btn-outline-success');
        acceptBtn.classList.add('btn-success');
      }
      acceptedBody.classList.add('acceptedResponse');
    }
  }

  if (closeIssueBtn) {
    closeIssueBtn.disabled = !acceptedResponseId;
  }
});

respondModalElement?.addEventListener('hidden.bs.modal', () => {
  activeIssueId = null;
});

respondModalElement
  ?.querySelectorAll('.replyBtn')
  .forEach((btn) => {
    btn.addEventListener('click', () => {
      const responseBody = btn.closest('.modelRespondBody');
      if (!responseBody) return;

      const form = responseBody.querySelector('.replyForm');
      if (!form) return;

      form.classList.toggle('d-none');
      if (!form.classList.contains('d-none')) {
        const textarea = form.querySelector('textarea');
        textarea?.focus();
      }
    });
  });

respondModalElement
  ?.querySelectorAll('.cancelReplyBtn')
  .forEach((btn) => {
    btn.addEventListener('click', () => {
      const form = btn.closest('.replyForm');
      if (!form) return;
      form.classList.add('d-none');
      const textarea = form.querySelector('textarea');
      if (textarea) {
        textarea.value = '';
        textarea.classList.remove('is-invalid');
      }
    });
  });

respondModalElement
  ?.querySelectorAll('.replyForm')
  .forEach((form) => {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const textarea = form.querySelector('textarea');
      if (!textarea) return;

      if (!textarea.value.trim()) {
        textarea.classList.add('is-invalid');
        showSolutionToast('Please enter a reply before submitting.', 'error');
        return;
      }

      textarea.classList.remove('is-invalid');

      const responseBody = form.closest('.modelRespondBody');
      if (!responseBody) return;

      const replyText = textarea.value.trim();
      const replyContainer = document.createElement('div');
      replyContainer.className = 'userReply';
      replyContainer.innerHTML = `<strong>Your reply:</strong> ${replyText}`;

      const existingReplies = responseBody.querySelectorAll('.userReply');
      if (existingReplies.length) {
        existingReplies[existingReplies.length - 1].after(replyContainer);
      } else {
        form.before(replyContainer);
      }

      textarea.value = '';
      form.classList.add('d-none');
      showSolutionToast('Reply submitted successfully.');

      if (activeIssueId) {
        const replyCard = document.querySelector(
          `.replyCard[data-issue-id="${activeIssueId}"]`
        );
        if (replyCard) {
          updateReplyCardState(replyCard, true);
          const preview = replyCard.querySelector('.userReplyPreview');
          const previewText = replyCard.querySelector('.userReplyPreviewText');
          if (preview && previewText) {
            previewText.textContent = replyText;
            preview.classList.remove('d-none');
          }
        }
      }
    });
  });

respondModalElement
  ?.querySelectorAll('.acceptSolutionBtn')
  .forEach((btn) => {
    btn.addEventListener('click', () => {
      if (!activeIssueId) {
        showSolutionToast('Please select a ticket first.', 'warning');
        return;
      }

      const responseBody = btn.closest('.modelRespondBody');
      if (!responseBody) return;

      respondModalElement
        .querySelectorAll('.modelRespondBody')
        .forEach((body) => {
          body.classList.remove('acceptedResponse');
          const tag = body.querySelector('.responseTag');
          if (tag) {
            tag.classList.remove('bg-success');
            tag.classList.add('bg-secondary');
            tag.textContent = 'Solution';
          }
          const acceptButton = body.querySelector('.acceptSolutionBtn');
          if (acceptButton) {
            acceptButton.disabled = false;
            acceptButton.innerHTML = '<i class="fa-solid fa-check"></i> Accept Solution';
            acceptButton.classList.remove('btn-success');
            acceptButton.classList.add('btn-outline-success');
          }
        });

      responseBody.classList.add('acceptedResponse');
      const tag = responseBody.querySelector('.responseTag');
      if (tag) {
        tag.classList.remove('bg-secondary');
        tag.classList.add('bg-success');
        tag.textContent = 'Accepted';
      }

      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Accepted';
      btn.classList.remove('btn-outline-success');
      btn.classList.add('btn-success');

      const responseId = responseBody.getAttribute('data-response-id');
      if (responseId) {
        acceptedResponsesByIssue[activeIssueId] = responseId;
      }

      if (closeIssueBtn) {
        closeIssueBtn.disabled = false;
      }

      showSolutionToast('Solution accepted successfully.');
    });
  });

closeIssueBtn?.addEventListener('click', () => {
  if (!activeIssueId) {
    showSolutionToast('No ticket selected to close.', 'warning');
    return;
  }

  if (!acceptedResponsesByIssue[activeIssueId]) {
    showSolutionToast('Please accept a solution before closing.', 'warning');
    return;
  }

  const respondTrigger = document.querySelector(
    `.respondBtn[data-issue-id="${activeIssueId}"]`
  );
  const card = respondTrigger?.closest('.card');
  const statusBadge = card?.querySelector('.statusBadge');

  if (statusBadge) {
    statusBadge.textContent = 'Closed';
    statusBadge.classList.remove('warning', 'info');
    statusBadge.classList.add('success');
  }

  if (respondTrigger) {
    respondTrigger.classList.add('disabled');
    respondTrigger.setAttribute('aria-disabled', 'true');
    respondTrigger.setAttribute('tabindex', '-1');
  }

  const modalInstance = bootstrap.Modal.getInstance(respondModalElement);
  modalInstance?.hide();
  showSolutionToast('Ticket closed successfully.');
});


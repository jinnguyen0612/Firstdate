<style>
    #question-input {
  width: 100%;
  padding: 8px;
  margin-bottom: 16px;
  border: 1px solid #ccd2dd;
  border-radius: 6px;
  font-size: 1rem;
}
.choice-row {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}
.choice-row input[type="text"] {
  flex: 1;
  padding: 7px;
  margin-right: 8px;
  border: 1px solid #ccd2dd;
  border-radius: 6px;
  font-size: 1rem;
}
.choice-row input[type="radio"] {
  margin-right: 7px;
}
.choice-row button {
  margin-left: 4px;
  background: #e55b5b;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 3px 8px;
  cursor: pointer;
  font-size: 1rem;
}
#add-choice-btn {
  background: #4a90e2;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 8px 12px;
  font-size: 1rem;
  margin-right: 8px;
  cursor: pointer;
  margin-top: 7px;
}
#submit-question-btn {
  background: #34b77b;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 8px 12px;
  font-size: 1rem;
  cursor: pointer;
  margin-top: 7px;
}
#questions-list {
  margin-top: 24px;
}
.question-item {
  background: #eef1f8;
  border-radius: 8px;
  padding: 18px 12px 12px 12px;
  margin-bottom: 18px;
}
.question-text {
  font-weight: bold;
}
.choices-list {
  margin: 10px 0 0 16px;
}
.choices-list li {
  margin-bottom: 3px;
}
.correct-answer {
  color: #34b77b;
  font-weight: bold;
}
@media (max-width: 600px) {
  .container {
    padding: 18px 7px;
  }
}
</style>
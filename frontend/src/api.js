import demoData from "@/demo_data.json";
import { DateTime } from "luxon";
const axios = require("axios").default;

class DemoAPI {
  async getDoctorsAndSpecs() {
    const fetched_doctors = await this.getDoctors();
    const fetched_specs = await this.getSpecialties();
    const fetched_timeslots = await this.getTimeslots();

    const mapTimeslots = new Map(
      fetched_timeslots.map((ts) => [parseInt(ts.doctor_id), ts])
    );
    const mapSpecs = new Map(fetched_specs.map((s) => [s.id, s]));

    const doctors = fetched_doctors.map((doctor) => {
      doctor.id = parseInt(doctor.id);
      const now = DateTime.now().startOf("day");

      doctor.spec = doctor.specialty.map((specId) => mapSpecs.get(specId));

      let mapCalendar = new Map();

      if (mapTimeslots.has(doctor.id)) {
        // Make calendar
        const days = mapTimeslots.get(doctor.id).slots;
        if (days && Object.keys(days).length > 0) {
          mapCalendar = new Map(
            Object.entries(days).map((slot) => {
              const dayISO = slot[0],
                day = new Map(slot[1].map((d) => [d.time, d]));

              day.dt = DateTime.fromISO(dayISO).setLocale("ru");
              day.ISO = dayISO;
              day.disabled = day.dt.ts < now || day.size < 1;
              // day.disabled = day.size < 1;
              day.isToday = day.dt.ts == now.ts;
              return [dayISO, day];
            })
          );
        }
      }
      mapCalendar.isActive = Array.from(mapCalendar.values()).some(
        (day) => !day.disabled
      );
      mapCalendar.selected = { dayISO: undefined, slot: undefined };
      doctor.calendar = mapCalendar;

      return doctor;
    });
    const mapDoctors = new Map(doctors.map((doc) => [doc.id, doc]));
    const specs = fetched_specs.filter((spec) =>
      doctors.some((doc) => doc.specialty.includes(spec.id))
    );
    return { doctors, mapDoctors, specs };
  }
  async getConfig() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return {
        pagination: {
          enabled: true,
          perPage: 10,
        },
      };
    });
  }
  async getDoctors() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return demoData.persons.slice(0, 70);
    });
  }
  async getSpecialties() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return demoData.specs;
    });
  }
  async getTimeslots() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return demoData.timeslots;
    });
  }
}
class API {
  SITE_URL = "http://localhost:8080";
  REST_URL = this.SITE_URL + "?rest_route=";
  ROUTES = {
    get_doctors: this.REST_URL + "/nillkizz-appointment/v1/get-doctors",
  };

  async getDoctorsAndSpecs() {
    const fetched_doctors = await this.getDoctors();
    const fetched_timeslots = await this.getTimeslots();

    const mapTimeslots = new Map(
      fetched_timeslots.map((ts) => [parseInt(ts.doctor_id), ts])
    );
    const doctors = fetched_doctors.map((doctor, key) => {
      doctor.id = key;
      const now = DateTime.now().startOf("day");

      let mapCalendar = new Map();

      if (mapTimeslots.has(doctor.id)) {
        // Make calendar
        const days = mapTimeslots.get(doctor.id).slots;
        if (days && Object.keys(days).length > 0) {
          mapCalendar = new Map(
            Object.entries(days).map((slot) => {
              const dayISO = slot[0],
                day = new Map(slot[1].map((d) => [d.time, d]));

              day.dt = DateTime.fromISO(dayISO).setLocale("ru");
              day.ISO = dayISO;
              day.disabled = day.dt.ts < now || day.size < 1;
              // day.disabled = day.size < 1;
              day.isToday = day.dt.ts == now.ts;
              return [dayISO, day];
            })
          );
        }
      }
      mapCalendar.isActive = Array.from(mapCalendar.values()).some(
        (day) => !day.disabled
      );
      mapCalendar.selected = { dayISO: undefined, slot: undefined };
      doctor.calendar = mapCalendar;

      return doctor;
    });
    const mapDoctors = new Map(doctors.map((doc) => [doc.id, doc]));
    const specs = new Map();
    doctors.forEach(doc => doc.specialty.forEach(spec => specs.set(spec.id, spec.val)));

    return { doctors, mapDoctors, specs };
  }
  async getConfig() {
    return demoApi.getConfig();
  }
  async getDoctors() {
    function formatTermsArray(terms) {
      return terms.map((term) => ({
        id: term.term_id,
        val: term.name,
      }));
    }
    const response = await axios.get(this.ROUTES.get_doctors);
    const doctors = response.data.map((doc) => {
      doc = { ...doc, ...doc.details };
      delete doc.details;
      doc.specialty = formatTermsArray(doc.specialty);
      doc.education = formatTermsArray(doc.education);
      return doc;
    });
    return doctors;
  }
  async getSpecialties() {
    return demoApi.getSpecialties();
  }
  async getTimeslots() {
    return demoApi.getTimeslots();
  }
}
const demoApi = new DemoAPI();
const api = new API();

export default api;
